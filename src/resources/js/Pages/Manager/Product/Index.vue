
<template>
    <!-- eslint-disable -->
    <div class="w-full">
        <header class="">
            <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Productos
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



            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold bg-blue-500 text-white">
                        <th class="px-6 py-3 text-center">Familia</th>
                        <th class="px-6 py-3 text-center">Marca</th>
                        <th class="px-6 py-3 text-center">Modelo</th>
                        <th class="px-6 py-3 text-center"></th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                    <tr v-for="product in products.data" :key="product.id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.family.nombre }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.brand.nombre }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.modelo }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            
                        </td>
                        <td class="border-t px-6 py-4 ">
                            <div class="flex justify-center">
                                <button
                                    class="text-xs font-semibold bg-blue-200 text-blue-800 rounded-md py-1 px-2 ">DETALLE</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <Pagination :links="products.links" class="flex justify-end mx-5 mb-5" />
        </div>
    </div>
</template>
<script>

import { ChevronDownIcon } from '@heroicons/vue/20/solid'

import { defineComponent } from 'vue'
import {
    PencilIcon,
    TrashIcon,
    PlusCircleIcon,
    XMarkIcon,
    CheckCircleIcon,
    ChevronRightIcon,
} from '@heroicons/vue/24/outline';
import Toast from '@/Layouts/Components/Toast.vue';


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
        
        ChevronDownIcon,
    },
    data() {

        return {
            products: {},
            open: false,
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
        }
    },

    methods: {
        async getProducts() {
            let response = await axios.get(route('products.list'))
            this.products = response.data

        },
        clearMessage() {
            this.toastMessage = ""
        },
    },

    created() {
        this.getProducts()
    },

})
</script>
    