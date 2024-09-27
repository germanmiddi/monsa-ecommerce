<template>
    
    <!-- eslint-disable -->
    <div class="w-full">
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Editar Página</h3>
                                    <button @click="editPage"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                                </div>
                            </div>

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
                            </div>


                            <div class="col-span-6 sm:col-span-6">
                                <label for="content"
                                    class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                <!-- <Tinymce ref="editor-content" v-model="form.content" :height="400" :toolbar="toolbar"></Tinymce> -->

                                <div class="quill-editor-container mb-10">
                                    <quill-editor ref="editor" v-model:value="form.content"
                                        :options="editorOptions"></quill-editor>
                                </div>

                            </div>

                        </div>
                    
                </div>
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 bg-gray-50">
                    <button @click="editPage" class="btn-blue">Guardar</button>
                </div>
            </div>

        </div>

    </div>
</template>


<script>

import { defineComponent } from 'vue'
import Icons from '@/Layouts/Components/Icons.vue'
import Toast from '@/Layouts/Components/Toast.vue'
import { ChevronLeftIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';
import Tinymce from '@/Layouts/Components/Tinymce/Tinymce.vue'
const toolbar = ['bold italic underline alignleft aligncenter alignright outdent indent  blockquote undo redo', 'hr bullist numlist link preview table forecolor backcolor ']
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import { quillEditor } from 'vue3-quill';

export default defineComponent({
    props: {
        pageId: {
            type: Number,
            required: true
        }
    },

    components: {
        Icons,
        Toast,
        ChevronLeftIcon,
        Inertia,
        Tinymce,
        VueDatePicker,
        quillEditor
    },

    data() {
        return {
            form: {
                content: ""
            },
            toastMessage: "",
            url: null,
            toolbar,
            postingDate: null,
            loading: false,
            editorOptions: {

            },
        }

    },
    setup() {

    },
    mounted() {
        this.getPage()
    },

    methods: {

        async getPage() {
            const response = await axios.get(route('pages.edit', this.pageId));
            this.form = response.data;
        },


        async editPage() {
            this.loading = true

            const url = route('pages.update');
            let formData = new FormData()

            formData.append('id', this.form.id)
            formData.append('title', this.form.title)
            formData.append('content', this.form.content)
            formData.append('slug', this.form.slug)

            try {
                const response = await axios.post(url, formData);
                console.log(response.data);
                this.$emit('message', { message: response.data.message, labelType: 'success' });

            } catch (error) {
                console.error(error);
            }

        },


    },

})
</script>

<style scoped>
.ql-container {
    height: 450px;
}

.quill-editor-container {
    height: 500px;
    /* O cualquier otra altura que se ajuste a tu diseño */
}

.ql-editor {
    height: 300px;
}
</style>