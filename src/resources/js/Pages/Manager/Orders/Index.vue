
<template>
    <!-- eslint-disable -->
        <div class="w-full" >
            <header class="">
                <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Ordenes
                    </h2>
                    <!-- <a class="btn-blue" :href="route('posts.create')">
                        Crear Nota
                    </a> -->
                </div>
            </header>
    
            <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
    
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="showToast" class="rounded-md bg-green-50 p-4 mb-5  ">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ this.message }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" @click="showToast = false"
                                    class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                    <span class="sr-only">Dismiss</span>
                                    <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="mt-2 mb-4">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div class="flex items-center justify-between flex-wrap sm:flex-nowrap ">
                            <div class="">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Filtro</h3>
                            </div>
                            <div class="flex-shrink-0">
                                <button v-if="Object.keys(this.filter).length"
                                    class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                    @click="clearFilter">Limpiar Filtro</button>
                                <button type="button"
                                    class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white"
                                    @click="getOrders()">Aplicar Filtro</button>

                                <label class="text-sm font-medium text-gray-700 mr-2 ml-4" for="">Ver: </label>
                                <select class="text-sm border-gray-300 rounded-md" v-model="length"
                                    @change="getOrders">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 sm:col-span-2">
                                <label for="id" class="block text-sm font-medium text-gray-700">Nro Orden</label>
                                <input v-model="filter.id" type="number" name="id" id="id" autocomplete="off"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="delivery_number" class="block text-sm font-medium text-gray-700">Delivery Number</label>
                                <input v-model="filter.delivery_number" type="text" name="delivery_number" id="delivery_number" autocomplete="off"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                                <input v-model="filter.cliente" type="text" name="cliente" id="cliente" autocomplete="off"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="producto" class="block text-sm font-medium text-gray-700">Producto</label>
                                <input v-model="filter.producto" type="text" name="producto" id="producto" autocomplete="off"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <table class="w-full whitespace-nowrap">
                        <tr class="text-left font-bold bg-blue-500 text-white">
                            <th class="px-5 py-3 text-center">ID</th>
                            <th class="px-5 py-3 text-center">Envío</th>
                            <th class="px-5 py-3 text-center">Fecha</th>
                            <th class="px-5 py-3 text-center">Cliente</th>
                            <th class="px-5 py-3 text-center">Estado</th>
                            <th class="px-5 py-3 text-center">Producto</th>
                            <th class="px-5 py-3 text-center">Total</th>
                            <th class="px-5 py-3 text-center">Acciones</th>
                        </tr>
                        <tr v-for="order in orders.data" :key="order.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100 text-xs ">
                            <td class="border-t px-5 py-4 text-center">
                                {{ order.id }}
                            </td>
                            <td class="border-t px-5 py-4 text-center">
                                {{ order.delivery }}
                            </td>
                            <td class="border-t px-5 py-4 text-center">
                                {{ order.created_at }}
                            </td>
                            <td class="border-t px-5 py-4 text-center">
                                {{ order.client.fullname }}
                            </td>
                            <td class="border-t px-5 py-4 text-center">
                                {{ order.status.name }}
                            </td>
                            <td class="border-t px-5 py-4 text-left">
                                {{ order.items[0].quantity }} x 
                                {{ order.items[0].product.nombre.substring(0, 30) }}
                            </td>
                            <td class="border-t px-5 py-4 text-right">
                                {{ formattedPrice( Number(order.total) ) }}
                            </td>
                            <td class="border-t px-5 py-4 ">
                                <div class="flex justify-center">
                                    <a :href="route('orders.detail', order.id)" class="text-xs font-semibold bg-blue-200 text-blue-800 rounded-md py-1 px-2 ">DETALLE</a>
                                </div>                                    
                            </td>                                
                                <!-- <div class="flex items-center">   
                                    <a type="button" :href="route('order.show', order.id)" 
                                       class="inline-flex items-center px-2 py-1 border border-gray-200 rounded-md bg-gray-100 
                                            hover:bg-gray-300 text-gray-700">
                                        <PencilIcon class="h-4 w-4 mr-2" aria-hidden="true" />Editar</a>
                                    <button class="ml-2 inline-flex items-center px-2 py-1 border border-gray-200 rounded-md bg-gray-100 
                                             hover:bg-gray-300 text-gray-700"
                                            @click="deleteOrder(order)">
                                            <TrashIcon class="h-3 w-3  mr-2 " aria-hidden="true" /> Borrar </button>
                                </div> -->
                            
                        </tr>
                    </table>
                    <hr>
                    <div class="flex justify-between mx-5 my-3 px-2 items-center text-sm">
                        <div>
                            Mostrando: {{ this.orders.from }} a {{ this.orders.to }} - Entradas encontradas:
                            {{ this.orders.total }}
                        </div>

                        <div class="flex flex-wrap -mb-1">
                            <template v-for="link in orders.links">
                                <div v-if="link.url === null"
                                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                    v-html="link.label"> </div>
                                <div v-else
                                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                    :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                    @click="getOrdersPaginate(link.url)" v-html="link.label"> </div>
                            </template>
                        </div>
                    </div>

                </div>
                <Pagination :links="orders.links" class="flex justify-end mx-5 mb-5" />
            </div>
        </div>
    
    
    
    </template>
    <script>

import { ChevronDownIcon } from '@heroicons/vue/20/solid'


    import { useFormatPrice } from '@/Composables/useFormatPrice.js';
    import { defineComponent } from 'vue'
    import { PencilIcon,
             TrashIcon,
             PlusCircleIcon,
             XMarkIcon,
             CheckCircleIcon,
             ChevronRightIcon,
             PhoneIcon,
             EnvelopeIcon          
            } from '@heroicons/vue/24/outline';
    import Toast from '@/Layouts/Components/Toast.vue';
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";        
    
    export default defineComponent({
        props: {
            toast: Object,
        },
        components: {
            TrashIcon,
            PencilIcon,
            PlusCircleIcon,
            Toast,
            XMarkIcon,
            CheckCircleIcon,
            ChevronRightIcon,
            PhoneIcon,
            EnvelopeIcon  ,
            useFormatPrice,
            Menu, MenuButton, MenuItems, MenuItem,
            ChevronDownIcon,
        },
        data() {
    
            return {
                orders: {},
                open: false,
                toastMessage: "",
                labelType: "info",
                message: "",
                showToast: false,
                filter: {},
                length: 15,
            }
        },
        setup() {
            const formattedPrice = (price) => useFormatPrice(price);
            return { 
                formattedPrice 
            }
        },    
        methods: {
            async getOrders() {

                let filter = `&length=${this.length}`

                if (this.filter.id) {
                    filter += `&id=${this.filter.id}`
                }

                if (this.filter.delivery_number) {
                    filter += `&delivery_number=${this.filter.delivery_number}`
                }

                if (this.filter.cliente) {
                    filter += `&cliente=${this.filter.cliente}`
                }

                if (this.filter.producto) {
                    filter += `&producto=${this.filter.producto}`
                }

                const get = `${route('orders.list')}?${filter}`

                const response = await fetch(get, { method: 'GET' })
                this.orders = await response.json()

            },

            clearMessage() {
                this.toastMessage = ""
            },

            async getOrdersPaginate(link) {

                var get = `${link}`;
                const response = await fetch(get, { method: 'GET' })

                this.orders = await response.json()
            },
            
            clearFilter() {
                this.filter = {}
                this.length = 15
                this.getOrders()
            },            

        },
    
        created() {
            this.getOrders()
        },
    
    })
    </script>
    