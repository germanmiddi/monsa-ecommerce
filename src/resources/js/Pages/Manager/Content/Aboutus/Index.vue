<template>
    <!-- eslint-disable -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-3">
                                <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Página Nosotros</h3>
                                    <button @click="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                                </div>
                            </div>
                        </div>                        
                        <div class="md:col-span-3 mt-5">
                            <div class="col-span-6 sm:col-span-6">
                                <label for="content"
                                    class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                                <div class="quill-editor-container mb-10">
                                    <quill-editor ref="editor" v-model:value="text.content" :options="editorOptions"></quill-editor>
                                </div>
                            </div>
                                                     
                            <div class="col-span-6 sm:col-span-3">
                                <label for="file" class="block text-sm font-medium text-gray-700">Imagen</label>
                                <span class="text-gray-500 text-sm">Se recomienda utilizar una imagen de 1400 x 1000px.</span>
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
                                    <button v-else @click="uploadImage" class="mt-2 ml-10 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Subir Imagen</button>
                                </div>
                            </div>
                            <div>
                                <hr>
                                <label for="Imagen"
                                    class="block text-sm font-medium text-gray-700 mb-2">
                                    <b>Imagen actual:</b></label>
                                    <div class="flex">
                                        <div v-for="images in this.img" :key="images.id">
                                            <img class="rounded-2xl w-52 ml-4" :src="`/storage/${images.content}`" alt="">
                                        </div>
                                    </div> 
                                <hr>
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
    import { quillEditor } from 'vue3-quill';

    export default {
        name: 'Aboutus',
        components: {
            TrashIcon,
            quillEditor
        },

        data(){
            const content1 = 
            `VULPUTATE ALIQUET VELIT FAUCIBUS
                Somos MONSA
                Sagittis scelerisque nulla cursus in enim consectetur quam. Dictum urna sed consectetur neque tristique pellentesque. Blandit amet, sed aenean erat arcu morbi.

                Sollicitudin tristique eros erat odio sed vitae, consequat turpis elementum. Lorem nibh vel, eget pretium arcu vitae. Eros eu viverra donec ut volutpat donec laoreet quam urna.

                Bibendum eu nulla feugiat justo, elit adipiscing. Ut tristique sit nisi lorem pulvinar. Urna, laoreet fusce nibh leo. Dictum et et et sit. Faucibus sed non gravida lectus dignissim imperdiet a.

                Dictum magnis risus phasellus vitae quam morbi. Quis lorem lorem arcu, metus, egestas netus cursus. In.

                Quis elit egestas venenatis mattis dignissim.
                Cras cras lobortis vitae vivamus ultricies facilisis tempus.
                Orci in sit morbi dignissim metus diam arcu pretium.
                Rhoncus nisl, libero egestas diam fermentum dui. At quis tincidunt vel ultricies. Vulputate aliquet velit faucibus semper. Pellentesque in venenatis vestibulum consectetur nibh id. In id ut tempus egestas. Enim sit aliquam nec, a. Morbi enim fermentum lacus in. Viverra.

                How we’re different
                Tincidunt integer commodo, cursus etiam aliquam neque, et. Consectetur pretium in volutpat, diam. Montes, magna cursus nulla feugiat dignissim id lobortis amet. Laoreet sem est phasellus eu proin massa, lectus. Diam rutrum posuere donec ultricies non morbi. Mi a platea auctor mi.

                Mauris ullamcorper imperdiet nec egestas mi quis quam ante vulputate. Vel faucibus adipiscing lacus, eget. Nunc fermentum id tellus donec. Ut metus odio sit sit varius non nunc orci. Eu, mi neque, ornare suspendisse amet, nibh. Facilisi volutpat lectus id sapien dis mauris rhoncus. Est rhoncus, interdum imperdiet ac eros, diam mauris, tortor. Risus id sit molestie magna.`
                
            return {
                form: {
                    content: content1
                },
                url: null,
                brandItems: [],
                // Data Aboutus
                text:[],
                img:[],
            }
        },
    
        methods: {
            
            async getData(){

                const page = 'aboutus';
                const section = 'content';
                const url = route('content.get', { page: page, section: section });
                const response = await axios.get(url);                

                // const response = await axios.get(`${route('content.get')}/home/banner`)
                const content = response.data

                this.text    = content.find(item => item.element === 'text');
                this.img = content.filter(item => item.element === 'img');

                console.log(this.img);
            },

            openDialogSearchImg() {
                this.$refs.import_file.click()
            },

            previewImage(e) {
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },     

            async uploadImage(){
                this.loading = true
                let data = {}

                try {
                    let formData = new FormData();
                    formData.append('image', this.form.image); // Asegúrate de que 'form.image' contenga el archivo a cargar
                    formData.append('type', this.form.type); // Asegúrate de que 'form.image' contenga el archivo a cargar

                    // Configura el header para el contenido multipart/form-data
                    const config = {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    };
                     
                    const response = await axios.post(route('content.about.store.image'), formData, config);
                    if (response.status == 200) {
                        data.message = response.data.message
                        data.labelType = 'success'
                    } else {
                        data.message = response.data.message
                        data.labelType = 'danger'
                    }
                } catch (error) {
                    data.message = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                    data.labelType = 'danger'
                }

                this.loading = false
                this.url  = null
                this.form = {}
                
                this.getSliderItems();
                this.$emit('message', data)
            },  


            async submit() {
                let data = new FormData();

                data.append('items[0][id]', this.text.id);
                data.append('items[0][content]', this.text.content);
               
                // Configura el header para el contenido multipart/form-data
                const config = {
                    headers: { 'Content-Type': 'multipart/form-data' }
                };

                try {
                    const response = await axios.post(route('content.about.store'), data, config);
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