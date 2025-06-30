<template>
    <!-- eslint-disable -->
    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="flex-1 min-w-0 flex items-center md:col-span-3">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Categorías</h3>
                        <a title="Nueva categoría" @click="toggleCreateForm">
                            <MinusCircleIcon v-if=showCreate class="ml-2 w-6 h-6 text-red-700" />
                            <PlusCircleIcon v-else class="ml-2 w-6 h-6 text-blue-700" />
                        </a>
                    </div>
                </div>

                <!-- Formulario para crear nuevo usuario -->
                <div v-show="showCreate" class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="text-sm font-medium leading-6 text-gray-900">Nombre</label>
                            <div class="mt-2.5">
                                <input type="text" v-model="form.name" name="name" id="name" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed" />
                            </div>
                        </div>
                        <div>
                            <label for="description" class="text-sm font-medium leading-6 text-gray-900">Descripción</label>
                            <div class="mt-2.5">
                                <textarea v-model="form.description" name="description" id="description" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed"></textarea>
                            </div>
                        </div>
                        <div>
                            <label for="image" class="text-sm font-medium leading-6 text-gray-900">Imagen</label>
                            <div class="mt-2.5">
                                <input type="file" @change="handleImageChange" name="image" id="image" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed" />
                                <p class="text-xs text-gray-500 mt-1">Tamaño máximo: 2MB</p>
                            </div>
                            <div v-if="imagePreviewUrl" id="image-preview" class="mt-2.5">
                                <img :src="imagePreviewUrl" alt="Imagen" class="w-20 h-20 object-cover rounded-md" />
                            </div>
                            <div v-else id="image-preview" class="mt-2.5">
                                <p class="text-xs text-gray-500 mt-1">No hay imagen seleccionada</p>
                            </div>
                        </div>
                        <div>
                            <label for="status" class="text-sm font-medium leading-6 text-gray-900">Estado</label>
                            <div class="mt-2.5">
                                <select v-model="form.status" name="status" id="status" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="active">Activo</option>
                                    <option value="inactive">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="meta_title" class="text-sm font-medium leading-6 text-gray-900">Meta Título</label>
                            <div class="mt-2.5">
                                <input type="text" v-model="form.meta_title" name="meta_title" id="meta_title" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed" />
                            </div>
                        </div>
                        <div>
                            <label for="meta_description" class="text-sm font-medium leading-6 text-gray-900">Meta Descripción</label>
                            <div class="mt-2.5">
                                <textarea v-model="form.meta_description" name="meta_description" id="meta_description" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed"></textarea>
                            </div>
                        </div>
                        <div>
                            <label for="parent_id" class="text-sm font-medium leading-6 text-gray-900">Padre</label>
                            <div class="mt-2.5">
                                <select v-model="form.parent_id" name="parent_id" id="parent_id" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="">Selecciona un padre</option>
                                    <option v-for="category in categories" :value="category.id" :key="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="storeCategory()"
                                :disabled="loading"
                                :class="[
                                    'flex-shrink-0 mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md',
                                    loading
                                        ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                        : 'bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white'
                                ]">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ loading ? 'Creando categoría...' : 'Guardar' }}
                        </button>
                    </div>
                </div>

                <!-- Tabla de categorías -->
                <div class="md:col-span-3 mt-5 overflow-x-auto">
                    <table class="w-full text-sm">
                        <tr class="text-left font-bold bg-blue-500 text-white">
                            <th class="px-2 py-2 text-left w-1/6">Nombre</th>
                            <th class="px-2 py-2 text-left w-1/6 hidden md:table-cell">Descripción</th>
                            <th class="px-2 py-2 text-left w-16">Imagen</th>
                            <th class="px-2 py-2 text-left w-20">Estado</th>
                            <th class="px-2 py-2 text-left w-1/6 hidden lg:table-cell">Meta Título</th>
                            <th class="px-2 py-2 text-left w-1/6 hidden xl:table-cell">Meta Descripción</th>
                            <th class="px-2 py-2 text-left w-20 hidden md:table-cell">Padre</th>
                            <th class="px-2 py-2 text-center w-24">Acciones</th>
                        </tr>
                        <CategoryItem v-for="item in categories"
                                        :key="item.id"
                                        :item="item"
                                        @message="messageToast"
                                        @refresh="getCategories"/>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryItem from './CategoryItem.vue'
import { PlusCircleIcon, MinusCircleIcon } from '@heroicons/vue/24/outline'

export default {

    components: {
        CategoryItem,
        PlusCircleIcon,
        MinusCircleIcon
    },

    data(){
        return {
            form: {},
            showCreate: false,
            categories: [],
            loading: false,
            imagePreviewUrl: null
        }
    },

    methods: {
        handleImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
                // Crear URL para vista previa
                this.imagePreviewUrl = URL.createObjectURL(file);
            } else {
                this.form.image = null;
                this.imagePreviewUrl = null;
            }
        },
        async getCategories() {
            try {
                console.log('getCategories')
                let response = await axios.get(route('categories.list'))
                this.categories = response.data
            } catch (error) {
                console.error('Error getting categories:', error)
            }
        },

        async storeCategory() {
            let data = {}
            this.loading = true; // Activar loader

            try {
                // Preparar datos para envío
                const formData = new FormData();

                // Agregar todos los campos del formulario
                Object.keys(this.form).forEach(key => {
                    if (this.form[key] !== null && this.form[key] !== undefined) {
                        formData.append(key, this.form[key]);
                    }
                });

                const response = await axios.post(route('categories.store'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showCreate = false
                } else {
                    data.message = response.data.message
                    data.labelType = 'danger'
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    data.message = 'Por favor revise los datos ingresados'
                    data.labelType = 'danger'
                } else {
                    data.message = 'Se ha producido un error al procesar | Comuníquese con el administrador'
                    data.labelType = 'danger'
                }
            } finally {
                this.loading = false; // Desactivar loader
            }

            this.clearForm()
            this.getCategories();
            this.$emit('message', data)
        },

        messageToast(data){
            this.$emit('message', data)
        },

        clearForm() {
            // Limpiar URL de vista previa para evitar memory leaks
            if (this.imagePreviewUrl) {
                URL.revokeObjectURL(this.imagePreviewUrl);
                this.imagePreviewUrl = null;
            }
            this.form = {};
        },

        toggleCreateForm() {
            if (this.showCreate) {
                // Si se está cerrando el formulario, limpiar los datos
                this.clearForm();
            }
            this.showCreate = !this.showCreate;
        }
    },

    mounted() {
        this.getCategories();
    },

}
</script>
