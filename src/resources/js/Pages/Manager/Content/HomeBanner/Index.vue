<template>
    <!-- eslint-disable -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Banner Promoción</h3>
                        <button @click="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                    </div>

                    <div class="grid grid-cols-6 mt-5 gap-6">
                        <div class="col-span-6 sm:col-span-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="title" id="title" v-model="title.content" maxlength="20"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <label for="subtitle" class="block text-sm font-medium text-gray-700">Sub Título</label>
                            <input type="text" name="subtitle" id="subtitle" v-model="subtitle.content" maxlength="25"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <label for="link" class="block text-sm font-medium text-gray-700">Link</label>
                            <input type="text" name="link" id="link" v-model="link.content"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 bg-gray-50">
                    <button @click="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>
        </div>
    </template>

    <script>
    import { TrashIcon } from '@heroicons/vue/24/outline'

    export default {

        components: {
            TrashIcon
        },

        data(){
            return {
                form: {},
                url: null,

                title:[],
                subtitle:[],
                link:[],
            }
        },

        methods: {

            async getData(){

                const page = 'home';
                const section = 'banner';
                const url = route('content.get', { page: page, section: section });
                const response = await axios.get(url);

                // const response = await axios.get(`${route('content.get')}/home/banner`)
                const content = response.data

                this.title    = content.find(item => item.element === 'h1');
                this.subtitle = content.find(item => item.element === 'h2');
                this.link     = content.find(item => item.element === 'link');

            },

            openDialogSearchImg() {
                this.$refs.import_file.click()
            },

            previewImage(e) {
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },

            async uploadImage(){

            },

            // async deleteItem(itemId){
            //     console.log(itemId)
            //     const response = await axios.post(route('content.slider.delete', itemId))
            //     this.getSliderItems();
            // }

            async submit() {
                let data = new FormData();

                // Append each piece of data to the FormData object, including their IDs.
                // This assumes that each `title`, `subtitle`, and `link` object has properties `id` and `content`.
                data.append('items[0][id]', this.title.id);
                data.append('items[0][content]', this.title.content);

                data.append('items[1][id]', this.subtitle.id);
                data.append('items[1][content]', this.subtitle.content);

                data.append('items[2][id]', this.link.id);
                data.append('items[2][content]', this.link.content);

                try {
                    const response = await axios.post(route('content.update'), data);
                    const content = response.data;
                    console.log(content);
                    alert('Actualizado con exito');
                } catch (error) {
                    console.error('Submission failed:', error);
                    alert('Error al actualizar');
                }
            }

        },

        created() {
            this.getData();
        },

    }
    </script>

    <style>

    </style>