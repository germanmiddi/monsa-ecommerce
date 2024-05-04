<template>
    <!-- eslint-disable -->
    <div class="w-full">
        <header class="">
            <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
                    <ChevronLeftIcon class="w-5 mr-2 rounded-full hover:bg-white" @click="goBack" /> Novedades - Editar Nota
                </h2>
                <button class="btn-blue" @click="submit">
                    Guardar
                </button>
            </div>
        </header>

        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Información</h3>
                                <p class="mt-1 text-sm text-gray-600">Indique los detalles de la nota</p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="#" method="POST">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                                        <input type="text" name="title" id="title" v-model="form.title"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                        <input type="text" name="slug" id="slug" v-model="form.slug"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-50 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="post_category_id"
                                            class="block text-sm font-medium text-gray-700">Categoría</label>
                                        <select id="post_category_id" name="post_category_id"
                                            v-model="form.post_category_id"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option disabled value="">Seleccione la categoría</option>
                                            <option value="1">Lanzamiento</option>
                                            <option value="2">Nuevo Ingreso</option>
                                            <option value="3">Lanzamiento</option>
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="post_status_id"
                                            class="block text-sm font-medium text-gray-700">Estado</label>
                                        <select id="post_status_id" name="post_status_id" v-model="form.post_status_id"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option disabled value="">Seleccione el estado</option>
                                            <option value="1">Borrador</option>
                                            <option value="2">Publicado</option>
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="date_published" class="block text-sm font-medium text-gray-700 mb-1">Fecha
                                            publicación</label>
                                        <DatePicker v-model="form.date_published" autoApply :enableTimePicker="false"
                                            :format="format" :minDate="currentDate"></DatePicker>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                    </div>


                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="file" class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <span class="text-gray-500 text-sm">Se recomienda utilizar una imagen cuadrada de al
                                            menos 1000px por lado.</span>
                                        <input name="file" type="file" hidden @change="previewImage"
                                            @input="form.image = $event.target.files[0]" ref="import_file" />
                                        <div class="flex flex-row items-center">
                                            <img v-if="url" :src="url" class="w-40" />

                                            <svg v-else @click="openDialogSearchImg()"
                                                class="w-40 h-40 text-gray-300 bg-white" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>

                                            <button
                                                class="ml-2 inline-flex items-center px-4 py-2 rounded-md font-semibold text-sm
                                                           bg-white border border-blue-500 text-blue-500  
                                                           hover:bg-blue-500 hover:text-white 
                                                           active:bg-blue-400 
                                                           focus:outline-none focus:border-blue-400 focus:ring focus:ring-blue-300 disabled:opacity-25 transition"
                                                @click.prevent="openDialogSearchImg()">
                                                <i class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </i>Buscar Imagen</button>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="content"
                                            class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                        <!-- <Tinymce ref="editor-content" v-model="form.content" :height="400" :toolbar="toolbar" :value="form.content"></Tinymce> -->
                                        <div class="quill-editor-container mb-10">
                                            <quill-editor 
                                                 :value="form.content"
                                                v-model:content="form.content" 
                                                @change="onEditorChange($event)">
                                            </quill-editor>
                                            <!-- <quill-editor 
                                                 :value="content"
                                                v-model:content="content" 
                                                @change="onEditorChange($event)">
                                            </quill-editor> -->

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

    
<script>

import { defineComponent, ref } from 'vue';
import Icons from '@/Layouts/Components/Icons.vue'
import Toast from '@/Layouts/Components/Toast.vue'
import { ChevronLeftIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
// import Tinymce from '@/Layouts/Components/Tinymce/Tinymce.vue'
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { quillEditor } from 'vue3-quill';


export default defineComponent({
    props: {
        post: Object,
    },

    components: {
        Icons,
        Toast,
        ChevronLeftIcon,
        Inertia,
        DatePicker,
        quillEditor        
    },

    data() {
        var data = {
            title: this.post.title,
            slug: this.post.slug,
            content: this.post.content,
            date_published: new Date(this.post.date_published+ "T00:00:00.000-03:00"),
            post_status_id: this.post.post_status_id,
            post_category_id: this.post.post_category_id,
            imageChanged: false
        }

        return {
            form: this.$inertia.form(data),
            url: this.post.image ? '/storage/' + this.post.image : "",
            toolbar,
            // content: this.post.content,
            editorOption: {
                theme: 'snow'
            }            
        }
    },

    setup() {
        const quillEditorRef = ref(null);

        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }

        return {
            format,
        }
    },

    methods: {
        goBack() {
            Inertia.visit(document.referrer);
        },
        clearMessage() {
            this.toastMessage = ""
        },

        submit() {
            this.loading = true
            //this.$inertia.post(route('posts.update', this.$props.post.id), this.form)
            this.$inertia.post(route('posts.update', this.$props.post.id), this.form).then(() => {
            // Redirecciona a otra página
                this.$inertia.visit(route('posts.list'));
            }).catch((error) => {
                // Maneja errores si es necesario
            });
        },

        openDialogSearchImg() {
            this.$refs.import_file.click()
        },

        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
            this.form.imageChanged = true
        },

        deleteImage() {
            this.form.image = ""
            this.url = ""
            this.form.imageChanged = true
        },
        onEditorChange({ quill, html, text }) {
            this.form.content = html
        }                  
    },
    created() {
        //this.getCity()
    }
})
</script>


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