
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
                                <button @click="open=true, this.product=product"
                                    class="text-xs font-semibold bg-blue-200 text-blue-800 rounded-md py-1 px-2">DETALLE</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <Pagination :links="products.links" class="flex justify-end mx-5 mb-5" />
        </div>
    </div>

    <!-- Panel lateral | detalle del producto -->
    <TransitionRoot as="template" :show="open">
            <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="open = false">
                <div class="absolute inset-0 overflow-hidden">
                    <DialogOverlay class="absolute inset-0" />

                    <div class="fixed inset-y-0 pl-16 max-w-full right-0 flex">
                        <TransitionChild as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full" enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0" leave-to="translate-x-full">
                            <div class="w-screen max-w-md border border-l-4 border-gray-400 rounded-md">
                                <form class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
                                    <div class="flex-1 h-0 overflow-y-auto">
                                        <div class="py-6 px-4 bg-blue-500 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <DialogTitle class="text-lg font-medium text-white"> Detalle del Producto
                                                </DialogTitle>

                                                <div class="ml-3 h-7 flex items-center">
                                                    <button type="button"
                                                        class="bg-blue-500 rounded-md text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                        @click="this.open=false">
                                                        <span class="sr-only">Cerrar</span>
                                                        <Icons name="x" class="w-6 h-6 text-white"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1 flex flex-col justify-between">
                                            <div class="px-4 divide-y divide-gray-200 sm:px-6">

                                                        <div class="space-y-2 pt-2 pb-5">
                                                            <div>
                                                                <label for="time"
                                                                    class="block text-md font-medium text-gray-700 "><b>{{this.product.nombre}}</b></label>
                                                            </div>
                                                            <hr>
                                                            <div class="flex justify-between">
                                                                <div class="w-1/2 text-center border-r-2 border-gray-50  bg-gray-100">
                                                                    <Icons v-if="this.product.show == 1" name="building-storefront" class="w-8 h-8 text-green-400 mx-auto mb-2 mt-2"/>
                                                                    <Icons v-else name="building-storefront" class="w-8 h-8 text-red-400 mx-auto mb-2 mt-2"/>
                                                                </div>
                                                                <!-- <div class="w-1/3 text-center border-r-2 border-gray-50  bg-gray-100 ">
                                                                    <Icons v-if="this.product.visibilidad === 'publicar'" name="eye" class="w-8 h-8 text-green-400 mx-auto mb-2 mt-2"/>
                                                                    <Icons v-else name="eye" class="w-8 h-8 text-red-400 mx-auto mb-2 mt-2"/>
                                                                </div> -->
                                                                <div class="w-1/2 text-center bg-gray-100">
                                                                    <Icons v-if="this.product.show_home == 1" name="star" class="w-8 h-8 text-green-400 mx-auto mb-2 mt-2"/>
                                                                    <Icons v-else name="star" class="w-8 h-8 text-red-400 mx-auto mb-2 mt-2"/>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">Familia:</label>
                                                                <span>{{ this.product.family?.nombre ?? '-' }}</span>
                                                            </div>

                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">Marca:</label>
                                                                <span>{{ this.product.brand?.nombre ?? '-' }}</span>
                                                            </div>

                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">Modelo:</label>
                                                                <span>{{ this.product.modelo ?? '-' }}</span>
                                                            </div>

                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">SKU:</label>
                                                                <span>{{ this.product.sku ?? '-' }}</span>
                                                            </div>

                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">Visibilidad:</label>
                                                                <span>{{ this.product.visibilidad ?? '-' }}</span>
                                                            </div>

                                                            <hr>
                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">Precio:</label>
                                                                <span>$ {{ this.product.precio ?? '-' }}</span>
                                                            </div>
                                                            <div class="flex text-sm text-gray-700">
                                                                <label class="text-bold w-24 font-bold">Peso: </label>
                                                                <span>{{ this.product.peso ?? '-' }}</span>
                                                            </div>
                                                            <hr>
                                                            <div>
                                                                <label for="comentario"
                                                                    class="block text-sm font-medium text-gray-700">
                                                                    <b>Descripción: </b></label>
                                                                <p class="text-xs text-justify">{{ this.product.descripcion }}</p>
                                                            </div>
                                                            <hr>
                                                            <div>
                                                                <label for="comentario"
                                                                    class="block text-sm font-medium text-gray-700">
                                                                    <b>Parametros de Busqueda: </b></label>
                                                                        <span  v-for="(search, index) in JSON.parse(this.product.search)" :key="index" 
                                                                            class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mr-2">
                                                                            {{search.replace(/['"]+/g, '')}}
                                                                        </span>
                                                            </div>
                                                            <hr>
                                                            <div>
                                                                <label for="comentario"
                                                                    class="block text-sm font-medium text-gray-700">
                                                                    <b>Imagenes </b></label>
                                                                    <div class="flex">
                                                                        <img v-for="(image,index) in JSON.parse(this.product.imagen)" :key="index"  class="rounded-3xl h-32 w-32" :src="`http://monsa-srl.com.ar/pedidosweb/${image}`" alt="">
                                                                    </div> 
                                                            </div>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 px-4 py-4 flex justify-end">
                                        <button type="button" @click="open=false"
                                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            >Ocultar</button>
                                    </div>
                                </form>
                            </div>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
        <!-- Fin panel lateral | detalle del producto -->
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
import Icons from '@/Layouts/Components/Icons.vue'
import Toast from '@/Layouts/Components/Toast.vue';
// Panel lateral.
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

export default defineComponent({
    props: {
        toast: Object,
    },
    components: {
        // Panel lateral
        Dialog, 
        DialogPanel, 
        DialogTitle, 
        TransitionChild, 
        TransitionRoot,
        // -- Icons
        Icons,
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
            product: {} ,
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            open: false, // Panel lateral
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
    