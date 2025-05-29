<script setup>
import { ref, onMounted } from "vue";
import { TrashIcon } from "@heroicons/vue/24/outline";
import { Switch } from "@headlessui/vue";

const form = ref({
    link: "",
    image: null,
    active: false,
});

const import_file = ref(null);
const url = ref(null);
const img = ref([]);
const loading = ref(false);
const previewImg = ref(null);

// Methods
const openDialogSearchImg = () => {
    import_file.value.click();
};

const previewImage = (e) => {
    const file = e.target.files[0];
    url.value = URL.createObjectURL(file);
};

const uploadImage = async () => {
    loading.value = true;
    let data = {};

    try {
        let formData = new FormData();
        formData.append("image", form.value.image);
        formData.append("type", form.value.type);

        const config = {
            headers: { "Content-Type": "multipart/form-data" },
        };

        const response = await axios.post(
            route("marketing.popup.store.image"),
            formData,
            config
        );
        if (response.status == 200) {
            data.message = response.data.message;
            data.labelType = "success";
        } else {
            data.message = response.data.message;
            data.labelType = "danger";
        }
    } catch (error) {
        data.message =
            "Se ha producido un error al procesar | Comuniquese con el administrador";
        data.labelType = "danger";
    }

    emit("message", data);
};

const submit = async () => {
    loading.value = true;

    try {
        let formData = new FormData();

        formData.append("link", form.value.link);
        formData.append("active", form.value.active);
        formData.append("image", form.value.image);

        const config = {
            headers: { "Content-Type": "multipart/form-data" },
        };

        const response = await axios.post(
            route("marketing.update"),
            formData,
            config
        );

        if (response.status == 200) {
            data.message = response.data.message || "Actualizado con éxito";
            data.labelType = "success";
        } else {
            data.message = response.data.message || "Error al actualizar";
            data.labelType = "danger";
        }
    } catch (error) {
        console.error("Submission failed:", error);
        data.message =
            "Se ha producido un error al procesar | Comuníquese con el administrador";
        data.labelType = "danger";
    }

    loading.value = false;
    emit("message", data);
};

const handleSwitchToggle = () => {
    form.value.active = !form.value.active;
};

const getContent = async () => {
    let response = await axios.get(
        route("content.get", {
            page: "marketing",
            section: "popup",
        })
    );
    let data = response.data;

    form.value.link = data.find(item => item.element === 'link')?.content;
    form.value.active = data.find(item => item.element === 'active')?.content;
    form.value.image = data.find(item => item.element === 'img')?.content;
    previewImg.value = data.find(item => item.element === 'img')?.content;
};

onMounted(() => {
    getContent();
});
</script>

<template>
    <!-- eslint-disable -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-3">
                        <div
                            class="px-4 sm:px-0 flex justify-between items-center mb-3"
                        >
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Popup Publicitario
                            </h3>
                            <button
                                @click="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-3 mt-5">
                    <div class="col-span-6 sm:col-span-6 mb-8">
                        <label
                            for="link"
                            class="block text-sm font-medium text-gray-700"
                            >Link</label
                        >
                        <input
                            v-model="form.link"
                            type="text"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3 mb-8">
                        <label
                            for="file"
                            class="block text-sm font-medium text-gray-700"
                            >Imagen</label
                        >
                        <span class="text-gray-500 text-sm"
                            >Se recomienda utilizar una imagen de 1000 x
                            1000px.</span
                        >
                        <input
                            name="file"
                            type="file"
                            hidden
                            @change="previewImage"
                            @input="form.image = $event.target.files[0]"
                            ref="import_file"
                        />
                        <div class="flex flex-row items-center">
                            <img v-if="url" :src="url" class="h-60" />

                            <svg
                                v-else
                                @click="openDialogSearchImg()"
                                class="w-40 h-40 text-gray-300 bg-white cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                />
                            </svg>

                            <button
                                v-if="!url"
                                class="ml-2 inline-flex items-center px-4 py-2 rounded-md font-semibold text-sm bg-white border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white active:bg-blue-400 focus:outline-none focus:border-blue-400 focus:ring focus:ring-blue-300 disabled:opacity-25 transition"
                                @click.prevent="openDialogSearchImg()"
                            >
                                <i class="mr-2"
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg> </i
                                >Buscar Imagen
                            </button>
                            <button
                                v-else
                                @click="uploadImage"
                                :disabled="loading"
                                class="mt-2 ml-10 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                            >
                                {{ loading ? "Subiendo..." : "Subir Imagen" }}
                            </button>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-3 mb-8">
                        <label
                            for="activeSwitch"
                            class="block text-sm font-medium text-gray-700"
                            >Activar</label
                        >
                        <Switch
                            v-model="form.active"
                            id="activeSwitch"
                            @click="handleSwitchToggle"
                            :class="form.active ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full mt-1"
                        >
                            <span
                                :class="
                                    form.active
                                        ? 'translate-x-6'
                                        : 'translate-x-1'
                                "
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                            />
                        </Switch>
                    </div>

                    <div>
                        <hr />
                        <label
                            for="Imagen"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            <b>Imagen actual:</b></label
                        >
                        <div class="flex">
                            <img
                                v-if="previewImg"
                                class="rounded-2xl w-52 ml-4"
                                :src="`/storage/${previewImg}`"
                                alt=""
                            />
                            <p
                                v-if="!previewImg"
                                class="text-gray-500 text-sm"
                            >
                                No hay imagen actual
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 bg-gray-50">
                <button
                    @click="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Guardar
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.ql-container {
    height: 450px;
}
.quill-editor-container {
    height: 500px; /* O cualquier otra altura que se ajuste a tu diseño */
}
.ql-editor {
    height: 300px;
}
</style>
