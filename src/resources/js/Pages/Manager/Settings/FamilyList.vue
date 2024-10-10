<template>
    <!-- eslint-disable -->
        <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-3">
                                <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Configuración de Familias</h3>
                                    <!-- <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 w-96  shadow-sm sm:text-sm border-gray-300 rounded-md"  placeholder="Buscar"/>
                                    <button class="btn-blue"> Nueva Locacion</button> -->
                                    
                                </div>
                            </div>
                        </div>                        
                        <div class="md:col-span-3 mt-5">
                            <table class="w-full whitespace-nowrap">
                                <tr class="text-left font-bold bg-blue-500 text-white">
                                    <th class="px-6 py-3 text-center">Familia</th>
                                    <th class="px-6 py-3 text-left">Activar</th>
                                </tr>
                                <FamilyItem v-for="item in families" 
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
    import  FamilyItem from './FamilyItem.vue'

    export default {
        
        components: {
            Switch,
            FamilyItem
        },

        data(){
            return {
                families: [],
            }
        },
    
        methods: {
            async getFamilies() {
                
                let response = await axios.get(route('settings.family.list'))
                this.families = response.data
    
            },
            messageToast(data){
                this.$emit('message', data)
            }
        },
    
        created() {
            this.getFamilies();
        },
    
    }
    </script>
    
    <style>
    
    </style>