<template>
    <!-- eslint-disable -->
        <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="flex-1 min-w-0 flex items-center md:col-span-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Configuración de Etiquetas</h3> 
                                <a title="Nueva etiqueta" @click="showCreate=!showCreate">
                                    <MinusCircleIcon v-if=showCreate class="ml-2 w-6 h-6 text-red-700" />
                                    <PlusCircleIcon v-else class="ml-2 w-6 h-6 text-blue-700" />
                                </a>
                            </div>
                        </div>   
                        <div v-show="showCreate" class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-5">
                            <div class="sm:col-span-2">
                                <label for="company" class="text-sm font-medium leading-6 text-gray-900">Nueva Etiqueta</label>
                                <div class="mt-2.5">
                                    <input type="text" v-model="form.nombre" name="nombre" id="nombre" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="button"@click="storeLabel()"
                                        class="flex-shrink-0 mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white">Guardar
                                </button>
                            </div>
                        </div>
                    
                        <div class="md:col-span-3 mt-5">
                            <table class="w-full whitespace-nowrap">
                                <tr class="text-left font-bold bg-blue-500 text-white">
                                    <th class="px-6 py-3 text-center">Etiqueta</th>
                                    <th class="px-6 py-3 text-left">Activar</th>
                                </tr>
                                <LabelItem v-for="item in labels" 
                                                :key="item.id"
                                                :item="item" @message="messageToast"/>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </template>
    
    <script>
    
    import { Switch } from '@headlessui/vue'
    import  LabelItem from './LabelItem.vue'
    import { PlusCircleIcon, MinusCircleIcon
  		} from '@heroicons/vue/24/outline' 

    export default {
        
        components: {
            Switch,
            LabelItem,
            PlusCircleIcon, 
            MinusCircleIcon
        },

        data(){
            return {
                labels: [],
                form: {},
                showCreate: false
            }
        },
    
        methods: {
            async getLabels() {
                
                let response = await axios.get(route('settings.label.list'))
                this.labels = response.data
    
            },
            async storeLabel() {
                let data = {}
                try {
                    const response = await axios.post(route('settings.label.store', this.form));
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

                this.form = {}
                this.getLabels();
                this.$emit('message', data)
            },
            messageToast(data){
                this.$emit('message', data)
            }
        },

    
        created() {
            this.getLabels();
        },
    
    }
    </script>
    