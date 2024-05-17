<template>
    <!-- eslint-disable -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-3">
                                <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Slider</h3>
                                    <button v-if="url" @click="uploadImage" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                                </div>
                            </div>
                        </div>                        
                        <div class="md:col-span-3 mt-5">
                            <div class="col-span-6 sm:col-span-3 mb-5">
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Imagen</label>
                                <select name="type" v-model="form.type" type="text" class="w-60 border border-gray-300 rounded-lg mt-2">
                                    <option value="desktop">Desktop</option>
                                    <option value="mobile">Mobile</option>
                                </select>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Tamaño Recomendado:</label>
                                <div class="text-gray-500 text-sm">Desktop: Imagen horizontal de 1920x600.</div>
                                <div class="text-gray-500 text-sm">Mobile: Imagen vertical de 820x1640.</div>
                            </div>
                                                        
                            <div class="col-span-6 sm:col-span-3">
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
                            </div>

                            <!-- <button v-if="url" @click="uploadImage" class="mt-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Subir</button> -->
                        </div>
                    </div>
                </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-3">
                            <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Desktop</h3>
                            </div>
                        </div>
                    </div>   
                    <div class="md:col-span-3 mt-5">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imagen
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Orden
                                    </th>
                                </tr>
                            </thead>
                            <draggable v-model="sliderItems.desktop" tag="tbody" class="bg-white divide-y divide-gray-200" @end="dragDesktop" :options="dragOptions">
                                <template #item="{element, index}">
                                    <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col mb-2 text-sm">
                                        <!-- <div class="text-gray-500 mb-2"> Tipo: <span class="text-gray-800 uppercase">{{ element.type }}</span> </div> -->
                                        <img :src="`/storage/${element.image}`"
                                            :class="{ 'w-4/5': element.type === 'desktop', 
                                                        'w-1/4': element.type === 'mobile'}" class="object-cover rounded-md" />
                                        </div>                                                      
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" >
                                        <div @click="deleteItem(element.id)" class="text-red-600 hover:text-red-700 flex bg-gray-100 px-2 py-1 rounded-lg hover:cursor">
                                        <TrashIcon class="w-4 mr-2"/>Eliminar
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" >
                                        <EllipsisVerticalIcon class="w-8 mr-8 drag-handle flex items-end"/>
                                    </td>
                                    </tr>
                                </template>
                            </draggable>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-3">
                            <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Mobile</h3>
                            </div>
                        </div>
                    </div>   
                    <div class="md:col-span-3 mt-5">
                        <!-- <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imagen
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in sliderItems.mobile" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col mb-2 text-sm">
                                            <div class="text-gray-500 mb-2"> Tipo: <span class="text-gray-800 uppercase">{{ item.type }}</span> </div>
                                            <img :src="`/storage/${item.image}`"
                                                    :class="{ 'w-4/5': item.type === 'desktop', 
                                                            'w-1/4': item.type === 'mobile'}" class="object-cover rounded-md" />
                                        </div>                                                      
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div @click="deleteItem(item.id)" class="text-red-600 hover:text-red-700 flex bg-gray-100 px-2 py-1 rounded-lg hover:cursor">
                                            <TrashIcon class="w-4 mr-2"/>Eliminar
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imagen
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Orden
                                    </th>
                                </tr>
                            </thead>
                            <draggable v-model="sliderItems.mobile" tag="tbody" class="bg-white divide-y divide-gray-200" @end="dragMobile" :options="dragOptions">
                                <template #item="{element, index}">
                                    <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col mb-2 text-sm">
                                        <!-- <div class="text-gray-500 mb-2"> Tipo: <span class="text-gray-800 uppercase">{{ element.type }}</span> </div> -->
                                        <img :src="`/storage/${element.image}`"
                                            :class="{ 'w-4/5': element.type === 'desktop', 
                                                        'w-1/4': element.type === 'mobile'}" class="object-cover rounded-md" />
                                        </div>                                                      
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" >
                                        <div @click="deleteItem(element.id)" class="text-red-600 hover:text-red-700 flex bg-gray-100 px-2 py-1 rounded-lg hover:cursor">
                                        <TrashIcon class="w-4 mr-2"/>Eliminar
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" >
                                        <EllipsisVerticalIcon class="w-8 mr-8 drag-handle flex items-end"/>
                                    </td>
                                    </tr>
                                </template>
                            </draggable>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </template>
    
    <script>
    import { TrashIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/outline'
    // Drag
    import draggable from 'vuedraggable'

    export default {
        
        components: {
            TrashIcon,
            EllipsisVerticalIcon,
            draggable
        },

        data(){
            return {
                form: {},
                url: null,
                sliderItems: [],
                drag: false,
                dragOptions: {
                    handle: '.drag-handle', // Especifica que el arrastre se activa solo cuando se hace clic en un elemento con la clase 'drag-handle'
                    filter: '.drag-handle' // Deshabilita el arrastre en los elementos que no tienen la clase 'drag-handle'
                }
            }
        },
    
        methods: {
            async getSliderItems(){
                const response = await axios.get(route('content.slider.list'))
                this.sliderItems = response.data                
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
                    
                    const response = await axios.post(route('content.slider.store', this.form, config));
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

                //let formData = new FormData();

                //formData.append('image', this.form.image); // Asegúrate de que 'form.image' contenga el archivo a cargar
                //formData.append('type', this.form.type); // Asegúrate de que 'form.image' contenga el archivo a cargar

                // Configura el header para el contenido multipart/form-data
                //const config = {
                //    headers: { 'Content-Type': 'multipart/form-data' }
                //};
                
                //const response = await axios.post(route('content.slider.store'), formData, config)

                //const data = response.data
                this.loading = false
                this.url  = null
                this.form = {}
                
                this.getSliderItems();
                this.$emit('message', data)
            },
            async deleteItem(itemId){
                let data = {}
                try {
                    /* let formData = new FormData();
                    formData.append('image', this.form.image); // Asegúrate de que 'form.image' contenga el archivo a cargar
                    formData.append('type', this.form.type); // Asegúrate de que 'form.image' contenga el archivo a cargar

                    // Configura el header para el contenido multipart/form-data
                    const config = {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }; */
                    
                    const response = await axios.post(route('content.slider.delete', itemId))
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

                //const response = await axios.post(route('content.slider.delete', itemId))
                this.getSliderItems();
                this.$emit('message', data)
            },
            async dragDesktop() {
                let data = {}
                try {
                    const response = await axios.post(route('content.slider.order'), JSON.stringify(this.sliderItems.desktop));
                    const content = response.data;
                    data.message = response.data.message
                    data.labelType = 'success'
                } catch (error) {
                    data.message = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                    data.labelType = 'danger'
                }
                this.$emit('message', data)
            },
            async dragMobile() {
                let data = {}
                try {
                    const response = await axios.post(route('content.slider.order'), JSON.stringify(this.sliderItems.mobile));
                    const content = response.data;
                    data.message = response.data.message
                    data.labelType = 'success'
                } catch (error) {
                    data.message = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                    data.labelType = 'danger'
                }
                this.$emit('message', data)
            },

        },
    
        created() {
            this.getSliderItems();
        },
        mounted() {
        },
    
    }
    </script>
    
    <style>
    /* Estilos para el icono de agarre */
    .drag-handle {
        cursor: grab;
    }
    </style>