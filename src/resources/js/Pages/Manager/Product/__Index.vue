
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
                                <div class="mt-2">
                                
                            </div>
                            </div>
                            <div class="flex-shrink-0">
                                <button v-if="Object.keys(this.filter).length" class="text-xs font-medium text-gray-500 hover:text-gray-700 mr-2"
                                        @click="clearFilter">Limpiar Filtro</button>
                                <button type="button"
                                    class="relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white" @click="getProducts()">Aplicar
                                    Filtro</button>

                                <label class="text-sm font-medium text-gray-700 mr-2 ml-4" for="">Ver: </label>
                                <select class="text-sm border-gray-300 rounded-md" v-model="length" @change="getProducts">
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
                                <select v-model="filter.family_id" id="family_id" name="family_id"
                                    autocomplete="off"
                                    class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="" disabled> - Seleccione una familia - </option>
                                    <option v-for="family in families" :key="family.id" :value="family.id">{{
                                        family.nombre
                                    }}</option>
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label for="brand_id" class="block text-sm font-medium text-gray-700">Marca</label>
                                <select v-model="filter.brand_id" id="brand_id" name="brand_id"
                                    autocomplete="off"
                                    class="uppercase mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="" disabled> - Seleccione una marca - </option>
                                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{
                                        brand.nombre
                                    }}</option>
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="label_id" class="block text-sm font-medium text-gray-700">Etiqueta</label>
                                <select v-model="filter.label_id" id="label_id" name="label_id"
                                    autocomplete="off"
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
                        Mostrando: {{  this.products.from  }} a {{  this.products.to  }} - Entradas encontradas:
                        {{  this.products.total  }}
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

    <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="open = false">
      <div class="absolute inset-0 overflow-hidden">
        <DialogOverlay class="absolute inset-0" />

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16">
          <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
            <div class="w-screen max-w-2xl">
              <form class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                <div class="flex-1">
                  <!-- Header -->
                  <div class="px-4 py-6 bg-gray-50 sm:px-6">
                    <div class="flex items-start justify-between space-x-3">
                      <div class="space-y-1">
                        <DialogTitle class="text-lg font-medium text-gray-900"> New project </DialogTitle>
                        <p class="text-sm text-gray-500">Get started by filling in the information below to create your new project.</p>
                      </div>
                      <div class="h-7 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-500" @click="open = false">
                          <span class="sr-only">Close panel</span>
                          <XIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- Divider container -->
                  <div class="py-6 space-y-6 sm:py-0 sm:space-y-0 sm:divide-y sm:divide-gray-200">
                    <!-- Project name -->
                    <div class="space-y-1 px-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                      <div>
                        <label for="project-name" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2"> Project name </label>
                      </div>
                      <div class="sm:col-span-2">
                        <input type="text" name="project-name" id="project-name" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" />
                      </div>
                    </div>

                    <!-- Project description -->
                    <div class="space-y-1 px-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                      <div>
                        <label for="project-description" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2"> Description </label>
                      </div>
                      <div class="sm:col-span-2">
                        <textarea id="project-description" name="project-description" rows="3" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md" />
                      </div>
                    </div>

                    <!-- Team members -->
                    <div class="space-y-2 px-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:px-6 sm:py-5">
                      <div>
                        <h3 class="text-sm font-medium text-gray-900">Team Members</h3>
                      </div>
                      <div class="sm:col-span-2">
                        <div class="flex space-x-2">
                          <a v-for="person in team" :key="person.email" :href="person.href" class="flex-shrink-0 rounded-full hover:opacity-75">
                            <img class="inline-block h-8 w-8 rounded-full" :src="person.imageUrl" :alt="person.name" />
                          </a>

                          <button type="button" class="flex-shrink-0 bg-white inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-dashed border-gray-200 text-gray-400 hover:text-gray-500 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Add team member</span>
                            <PlusSmIcon class="h-5 w-5" aria-hidden="true" />
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="px-4 py-5 sm:px-0 sm:py-0">
                    <dl class="space-y-8 sm:divide-y sm:divide-gray-200 sm:space-y-0">
                      <div class="sm:flex sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0 lg:w-48">Bio</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:ml-6 sm:col-span-2">
                          <p>Enim feugiat ut ipsum, neque ut. Tristique mi id elementum praesent. Gravida in tempus feugiat netus enim aliquet a, quam scelerisque. Dictumst in convallis nec in bibendum aenean arcu.</p>
                        </dd>
                      </div>
                      <div class="sm:flex sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0 lg:w-48">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:ml-6 sm:col-span-2">New York, NY, USA</dd>
                      </div>
                      <div class="sm:flex sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0 lg:w-48">Website</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:ml-6 sm:col-span-2">ashleyporter.com</dd>
                      </div>
                      <div class="sm:flex sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0 lg:w-48">Birthday</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:ml-6 sm:col-span-2">
                          <time datetime="1982-06-23"> June 23, 1982 </time>
                        </dd>
                      </div>
                    </dl>
                  </div>
                  </div>
                </div>

                <!-- Action buttons -->
                <div class="flex-shrink-0 px-4 border-t border-gray-200 py-5 sm:px-6">
                  <div class="space-x-3 flex justify-end">
                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="open = false">Cancel</button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create</button>
                  </div>
                </div>
              </form>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
         
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

        Switch
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
            //Filtros
            length: 10,
            filter: {},

            labelSelect: '',
            labelsSelected: []
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
        async storeLabel() {
            
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
        addLabel(){
            let existe_label = this.labelsSelected.find( label => label === this.labelSelect );
            if(this.labelSelect === ''){
                this.labelType = "info";
                this.toastMessage = "Debe ingresar un valor en la etiqueta";
            }else{
                if(!existe_label)
                {
                    this.labelsSelected.push(this.labelSelect);
                }else{
                    this.labelType = "info";
                    this.toastMessage = "La etiqueta ya se encuentra asignada";
                }
            }
            this.labelSelect = '';
        },
        removeLabel(label){
            const index = this.labelsSelected.findIndex(item => item === label);
            this.labelsSelected.splice(index, 1);
            this.labelType = "success";
            this.toastMessage = "Se ha eliminado correctamente la etiqueta";
        },
        loadProduct(product){
            this.open=true
            this.product=product
            this.labelsSelected = []
            this.product.labels.forEach(element => {
                this.labelsSelected.push(element.nombre)
            });
        },
        clearMessage() {
            this.toastMessage = ""
        },
        clearFilter(){
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
    