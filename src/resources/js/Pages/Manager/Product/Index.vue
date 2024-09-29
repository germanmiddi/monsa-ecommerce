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
                                    @click="getProducts()">Aplicar
                                    Filtro</button>

                                <label class="text-sm font-medium text-gray-700 mr-2 ml-4" for="">Ver: </label>
                                <select class="text-sm border-gray-300 rounded-md" v-model="length"
                                    @change="getProducts">
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
                            <div class="col-span-12 sm:col-span-1">
                                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                                <input v-model="filter.sku" type="text" name="sku" id="sku" autocomplete="off"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                                <input v-model="filter.modelo" type="text" name="modelo" id="modelo" autocomplete="off"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="family_id" class="block text-sm font-medium text-gray-700">Familia</label>
                                <select v-model="filter.family_id" id="family_id" name="family_id" autocomplete="off"
                                    class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="" disabled> - Seleccione una familia - </option>
                                    <option v-for="family in families" :key="family.id" :value="family.id">{{
                                        family.nombre
                                        }}</option>
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label for="brand_id" class="block text-sm font-medium text-gray-700">Marca</label>
                                <select v-model="filter.brand_id" id="brand_id" name="brand_id" autocomplete="off"
                                    class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="" disabled> - Seleccione una marca - </option>
                                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{
                                        brand.nombre
                                        }}</option>
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="label_id" class="block text-sm font-medium text-gray-700">Etiqueta</label>
                                <select v-model="filter.label_id" id="label_id" name="label_id" autocomplete="off"
                                    class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="" disabled> - Seleccione una etiqueta - </option>
                                    <option v-for="label in labels" :key="label.id" :value="label.id">{{
                                        label.nombre
                                        }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold bg-blue-500 text-white">
                        <th class="px-6 py-3 text-center">SKU</th>
                        <th class="px-6 py-3 text-center">Familia</th>
                        <th class="px-6 py-3 text-center">Marca</th>
                        <th class="px-6 py-3 text-center">Modelo</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                    <tr v-for="product in products.data" :key="product.id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.sku }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.family.nombre }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.brand.nombre }}
                        </td>
                        <td class="border-t px-6 py-4 text-center">
                            {{ product.modelo }}
                        </td>
                        <td class="border-t px-6 py-4 ">
                            <div class="flex justify-center">
                                <button @click="loadProduct(product)"
                                    class="text-xs font-semibold bg-blue-200 text-blue-800 rounded-md py-1 px-2">DETALLE</button>
                            </div>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="flex justify-between mx-5 my-3 px-2 items-center text-sm">
                    <div>
                        Mostrando: {{ this.products.from }} a {{ this.products.to }} - Entradas encontradas:
                        {{ this.products.total }}
                    </div>

                    <div class="flex flex-wrap -mb-1">
                        <template v-for="link in products.links">
                            <div v-if="link.url === null"
                                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded-md"
                                v-html="link.label"> </div>
                            <div v-else
                                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer"
                                :class="{ 'bg-blue-500': link.active }, { 'text-white': link.active }"
                                @click="getProductsPaginate(link.url)" v-html="link.label"> </div>
                        </template>
                    </div>
                </div>
            </div>
            <!-- <Pagination :links="products.links" class="flex justify-end mx-5 mb-5" /> -->
        </div>
    </div>

    <!-- Panel lateral | detalle del producto -->
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="open = false">
            <div class="absolute inset-0 overflow-hidden">
                <DialogOverlay class="absolute inset-0" />

                <div class="fixed inset-y-0 pl-16 max-w-full right-0 flex">
                    <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700"
                        enter-from="translate-x-full" enter-to="translate-x-0"
                        leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0"
                        leave-to="translate-x-full">
                        <div class="w-screen max-w-xl rounded-md">
                            <form class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
                                <div class="flex-1 h-0 overflow-y-auto">
                                    <div class="py-6 px-4 bg-blue-500 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <DialogTitle class="text-lg font-medium text-white"> Detalle del Producto
                                            </DialogTitle>

                                            <div class="ml-3 h-7 flex items-center">
                                                <button type="button"
                                                    class="bg-blue-500 rounded-md text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                    @click="this.open = false">
                                                    <span class="sr-only">Cerrar</span>
                                                    <Icons name="x" class="w-6 h-6 text-white" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between">
                                        <div class="px-4 divide-y divide-gray-200 sm:px-6">

                                            <div class="space-y-4 pt-2 pb-5">
                                                <div>
                                                    <label for="time"
                                                        class="block text-md font-medium text-gray-700 "><b>{{ this.product.nombre }}</b></label>
                                                </div>
                                                <hr class="p-2">
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Activo:</label>
                                                    <Switch v-model="product.is_active"
                                                        @click="product.is_active = !product.is_active"
                                                        :class="product.is_active ? 'bg-blue-600' : 'bg-gray-200'"
                                                        class="relative inline-flex h-6 w-11 items-center rounded-full">
                                                        <span
                                                            :class="product.is_active ? 'translate-x-6' : 'translate-x-1'"
                                                            class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                                                    </Switch>
                                                </div>
                                                <hr class="p-2">
                                                <div class="flex text-sm text-gray-700 mt-4">
                                                    <label class="text-bold w-40 font-bold">Familia:</label>
                                                    <span>{{ this.product.family?.nombre ?? '-' }}</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Marca:</label>
                                                    <span>{{ this.product.brand?.nombre ?? '-' }}</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Modelo:</label>
                                                    <span>{{ this.product.modelo ?? '-' }}</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">SKU:</label>
                                                    <span>{{ this.product.sku ?? '-' }}</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Visibilidad:</label>
                                                    <span>{{ this.product.visibilidad ?? '-' }}</span>
                                                </div>

                                                <hr class="p-2">

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Precio:</label>
                                                    <span>$ {{ this.product.precio ?? '-' }}</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Precio Público:</label>
                                                    <span>$ {{ this.product.price_public ?? '-' }}</span>
                                                </div>

                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Peso: </label>
                                                    <span>{{ this.product.peso ?? '-' }}</span>
                                                </div>
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Alto: </label>
                                                    <span>{{ this.product.dimensiones ?
                                                        JSON.parse(this.product.dimensiones).alto ?? '-' : '-'}}</span>
                                                </div>
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Largo: </label>
                                                    <span>{{ this.product.dimensiones ?
                                                        JSON.parse(this.product.dimensiones).largo ?? '-' : '-'}}</span>
                                                </div>
                                                <div class="flex text-sm text-gray-700">
                                                    <label class="text-bold w-40 font-bold">Ancho: </label>
                                                    <span>{{ this.product.dimensiones ?
                                                        JSON.parse(this.product.dimensiones).ancho ?? '-' : '-'}}</span>
                                                </div>

                                                <hr class="p-2">
                                                <div>
                                                    <h2 class="text-lg font-bold">Stock</h2>
                                                    <div class="space-y-1 pr-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                                                        <div>
                                                            <label for="stock_disponible"
                                                                class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Stock Disponible: </label>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <input type="number" name="stock_disponible" id="stock_disponible" v-model="product.stock_disponible"
                                                                class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" />
                                                        </div>
                                                        <div>
                                                            <label for="stock_reservado"
                                                                class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                                                Stock Reservado: </label>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <input type="number" name="stock_reservado" id="stock_reservado" readonly v-model="product.stock_reservado"
                                                                class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md bg-gray-100" />
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                

                                                <hr class="p-2">

                                                <div class="col-span-6 sm:col-span-6">
                                                    <label for="content"
                                                        class="block font-bold mb-4 text-sm text-gray-700">Descripción: </label>

                                                    <div class="quill-editor-container mb-10">
                                                        <quill-editor ref="editor" v-model:value="this.product.descripcion"
                                                            :options="editorOptions"></quill-editor>
                                                    </div>

                                                </div>
                                                <hr class="p-2">
                                                <div>
                                                    <label for="search"
                                                        class="block text-sm font-bold text-gray-700 mb-4">Parámetros de
                                                        Busqueda:</label>
                                                    <span v-for="(search, index) in JSON.parse(this.product.search)"
                                                        :key="index"
                                                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 m-3 ">
                                                        {{ search.replace(/['"]+/g, '') }}
                                                    </span>
                                                </div>
                                                <hr class="p-2">
                                                <div>
                                                    <label for="labels" class="block text-sm font-medium text-gray-700">
                                                        Etiquetas: </label>
                                                    <div class="flex items-center mb-2">
                                                        <input type="text" list="labels_from" v-model="labelSelect"
                                                            id="label_id"
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        <datalist id="labels_from">
                                                            <option v-for="lab in labels" :value="lab.nombre"
                                                                :key="lab.id">
                                                                {{ lab.nombre }}</option>
                                                        </datalist>
                                                        <a class="ml-2 items-center" @click="addLabel">
                                                            <PlusCircleIcon class="h-8 w-8 text-blue-700">
                                                            </PlusCircleIcon>
                                                        </a>
                                                    </div>
                                                    <span v-for="(label, index) in this.labelsSelected" :key="index"
                                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10 mr-2">
                                                        {{ label }} <TrashIcon @click="removeLabel(label)"
                                                            class="h-5 w-5 text-red-700 ml-2"></TrashIcon>
                                                    </span>
                                                </div>
                                                <hr class="p-2">
                                                <div>
                                                    <h2 class="text-lg font-bold">Promociones</h2>

                                                    <div class="space-y-1 pr-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Activar Promoción:</label>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <Switch v-model="product.promo_active"
                                                            @click="product.promo_active = !product.promo_active"
                                                            :class="product.promo_active ? 'bg-blue-600' : 'bg-gray-200'"
                                                            class="relative inline-flex h-6 w-11 items-center rounded-full">
                                                            <span
                                                                :class="product.promo_active ? 'translate-x-6' : 'translate-x-1'"
                                                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                                                            </Switch>
                                                        </div>
                                                        <div>
                                                            <label for="promo_text" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Texto
                                                                Promoción: </label>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <input type="text" name="promo_text" id="promo_text" v-model="product.promo_text"
                                                                class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" />
                                                        </div>
                                                        <div>
                                                            <label for="project-name"
                                                                class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                                                Precio Promoción: </label>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500 sm:text-sm"> $ </span>
                                                                </div>
                                                                <input type="text" name="price" id="price" v-model="product.promo_price" 
                                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" aria-describedby="price-currency" />
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="p-2">
                                                <div>
                                                    <label for="images" class="block text-sm font-medium text-gray-700">
                                                        Imagenes</label>
                                                    <div class="flex">
                                                        <img v-for="(image, index) in JSON.parse(this.product.imagen)"
                                                            :key="index" class="rounded-3xl h-32 w-32"
                                                            :src="`http://monsa-srl.com.ar/pedidosweb/${image}`" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 px-4 py-4 flex justify-end">
                                    <button type="button" @click="updateProduct()"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                                    <button type="button" @click="open = false"
                                        class="ml-2 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Ocultar</button>
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
import { Switch } from '@headlessui/vue'
import { quillEditor } from 'vue3-quill';



export default defineComponent({
    props: {
        toast: Object,
        families: Object,
        brands: Object,
        labels: Object
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
        quillEditor,
        Switch
    },
    data() {

        return {
            products: {},
            product: {},
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
            open: false, // Panel lateral
            //Filtros
            length: 10,
            filter: {},

            labelSelect: '',
            labelsSelected: [],
            editorOptions: {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        
                    ]
                }
            },
        }
    },

    methods: {
        async getProducts() {
            /* let response = await axios.get(route('products.list'))
            this.products = response.data */
            let filter = `&length=${this.length}`

            if (this.filter.modelo) {
                filter += `&modelo=${JSON.stringify(this.filter.modelo)}`
            }

            if (this.filter.family_id) {
                filter += `&family_id=${JSON.stringify(this.filter.family_id)}`
            }

            if (this.filter.brand_id) {
                filter += `&brand_id=${JSON.stringify(this.filter.brand_id)}`
            }

            if (this.filter.label_id) {
                filter += `&label_id=${JSON.stringify(this.filter.label_id)}`
            }

            if (this.filter.sku) {
                filter += `&sku=${JSON.stringify(this.filter.sku)}`
            }

            const get = `${route('products.list')}?${filter}`

            const response = await fetch(get, { method: 'GET' })
            this.products = await response.json()

        },

        async getProductsPaginate(link) {

            var get = `${link}`;
            const response = await fetch(get, { method: 'GET' })

            this.products = await response.json()
        },

        async updateProduct() {

            try {
                this.product.labelDetails = this.labelsSelected;
                const response = await axios.post(route('products.update', this.product.id), this.product);
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
            this.open = false;
            this.getProducts();
        },

        addLabel() {
            let existe_label = this.labelsSelected.find(label => label === this.labelSelect);
            if (this.labelSelect === '') {
                this.labelType = "info";
                this.toastMessage = "Debe ingresar un valor en la etiqueta";
            } else {
                if (!existe_label) {
                    this.labelsSelected.push(this.labelSelect);
                } else {
                    this.labelType = "info";
                    this.toastMessage = "La etiqueta ya se encuentra asignada";
                }
            }
            this.labelSelect = '';
        },

        removeLabel(label) {
            const index = this.labelsSelected.findIndex(item => item === label);
            this.labelsSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente la etiqueta";
        },

        loadProduct(product) {
            this.open = true
            this.product = product
            this.labelsSelected = []
            this.product.labels.forEach(element => {
                this.labelsSelected.push(element.nombre)
            });
        },

        clearMessage() {
            this.toastMessage = ""
        },

        clearFilter() {
            this.filter = {}
            this.length = 10
            this.getProducts()
        },

    },

    created() {
        this.getProducts()
    },

})
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