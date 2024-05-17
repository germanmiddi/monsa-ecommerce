<template>
    <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
    <!-- eslint-disable -->
    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-3">
                            <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Configuración General</h3>
                                <!-- <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 w-96  shadow-sm sm:text-sm border-gray-300 rounded-md"  placeholder="Buscar"/>
                                <button class="btn-blue"> Nueva Locacion</button> -->
                                
                            </div>
                        </div>
                    </div>                        
                    <div class="mt-5">

                        <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                            <div>
                                Sincronizacion de Familias<br>
                                <span class="text-gray-400 text-sm">Última ejecución 01/04/2024 - 14:33 </span>
                            </div>
                            <button @click="getFamilies()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                            <div>
                                Sincronizacion de Marcas<br>
                                <span class="text-gray-400 text-sm">Última ejecución 01/04/2024 - 14:33 </span>
                            </div>
                            <button @click="getBrands()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                            <div>
                                Sincronizacion de Atributos<br>
                                <span class="text-gray-400 text-sm">Última ejecución 01/04/2024 - 14:33 </span>
                            </div>
                            <button @click="getAtributes()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                            <div>
                                Sincronizacion de Productos<br>
                                <span class="text-gray-400 text-sm">Última ejecución 01/04/2024 - 14:33 </span>
                            </div>
                            <button @click="getProducts()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                        </div>

                    </div>
                </div>
            </div>
            </div>
</template>
    
<script>   
import Toast from '@/Layouts/Components/Toast.vue'

export default {
    components: {
		Toast
	},
    data() {
        return {
            toastMessage: "",
			labelType:    "info",
        }
    },
    methods: {
        clearMessage() {
			this.toastMessage = "";
		},
        async getFamilies() {

            const url = route('import.families')
            
            try {
                const response = await axios.get(url)
                if (response.status == 200) {
					this.toastMessage = response.data.message
                    this.labelType = 'success'
				} else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
				} 
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }
            
        },
        async getBrands() {

            const url = route('import.brands')
            
            try {
                const response = await axios.get(url)
                if (response.status == 200) {
					this.toastMessage = response.data.message
                    this.labelType = 'success'
				} else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
				} 
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }

        },

        async getAtributes() {

            const url = route('import.atributes')
            
            try {
                const response = await axios.get(url)
                if (response.status == 200) {
					this.toastMessage = response.data.message
                    this.labelType = 'success'
				} else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
				} 
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }

        },
        
        async  getProducts() {

            const url = route('import.products')
            
            this.labelType = 'info';
            this.toastMessage = 'Se ha inciado proceso de importación de producto';

            try {
                const response = await axios.get(url)
                if (response.status == 200) {
					this.toastMessage = response.data.message
                    this.labelType = 'success'
				} else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
				} 
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }

        }
    }
}


</script>
