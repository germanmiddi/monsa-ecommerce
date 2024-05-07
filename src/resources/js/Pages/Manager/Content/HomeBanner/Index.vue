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
                        <!-- <div class="col-span-6 sm:col-span-3">
                            <input name="file" type="file" hidden @change="previewImage"
                                @input="form.image = $event.target.files[0]" ref="import_file" />
                            <div class="flex flex-row items-center">
                                <img v-if="url" :src="url" class="h-60" />

                                <svg v-else @click="openDialogSearchImg()"
                                    class="w-40 h-40 text-gray-300 bg-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>

                                <button v-if="!url" 
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
                        </div> -->

                        <!-- <button v-if="url" @click="uploadImage" class="mt-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Subir</button> -->

                    </div>
                    
                    <!-- <div class="md:col-span-3 mt-5">
                        <div class="grid grid-cols-3"> 
                            <div v-for="item in brandItems" :key="item.id" class="col-span-1">
                                <div class="flex flex-col items-center justify-center">
                                    <img :src="`/storage/${item.image}`" class="h-40" />
                                    <div class="flex justify-center items-center mt-2">
                                        <button class="text-red-500" @click="deleteItem(item.id)">
                                            <TrashIcon class="w-6 h-6" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

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