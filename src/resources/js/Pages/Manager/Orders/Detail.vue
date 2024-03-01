
<template>
    <!-- eslint-disable -->
    <div class="w-full">
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
        <div class="focus-within:content flex-grow flex flex-col xl:w-11/12 lg:w-11/12 mx-auto">
            <div class="mt-14 flex justify-between">
                <div class="flex items-center">
                    <ChevronLeftIcon @click="backPage"
                                     class="w-7 h-7 mr-2 border-gray-500 text-gray-500 rounded-full hover:bg-white cursor-pointer " />
                    <h1 class="text-2xl font-bold">Orden #{{ order.id }}</h1>
                    <span></span>
                    <span></span>
                </div>

                <div class="flex">
                    <!-- <button v-if="this.order.ship_status != 'finished'" @click="createShipmentDhl" class="btn-default">
                        <span>Crear Envio DHL</span>
                        <div v-if="this.loadingDhl == true" ><Icons name="cog" class="ml-2 w-6 h-6 animate-spin"/></div>
                    </button>
                    <button v-if="this.order.bill_status != 'finished'" @click="createInvoice" class="btn-default">
                        <span>Emitir Factura</span>
                        <div v-if="this.loading == true" ><Icons name="cog" class="ml-2 w-6 h-6 animate-spin"/></div>
                    </button> -->
                    <!-- <a href="#" class="btn-default">
                        <span>Imprimir</span>
                    </a> -->
                    <a href="#" class="btn-default">
                        <span>Finalizar</span>
                    </a>
                </div>
            </div>

            <span class="mb-4">Creado: {{formatDateDMY(order.created_at)}}</span>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2">
                    <div class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Resumen del Pedido</div>
                            <div class="p-4">(1 Items)</div>
                        </div>
                        <div class="card-body text-sm px-4 py-5">
                            <table class="w-full mt-2">
                                <tr v-for="item in order.items" :key="item.id" class="w-full">
                                    <td class="w-4/6 font-bold">{{item.product.nombre}}</td>
                                    <td class="w-2/6 text-right">
                                        {{formattedPrice( Number(item.price) )}} 
                                        <span class="mx-2 font-bold">x {{item.quantity}} </span>
                                        {{formattedPrice( Number(item.total) )}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Información de Pago</div>
                        </div>
                        <div class="card-body">
                            <table class="w-full mt-2">
                                <tr>
                                    <td class="w-5/6">Subtotal</td>
                                    <td class="w-1/6 text-right">$ </td>
                                </tr>
                                <tr>
                                    <td class="w-5/6">Shipping</td>
                                    <td class="w-1/6 text-right">$ 0.00</td>
                                </tr>
                                <!-- <tr>
                                    <td class="w-5/6">Tax</td>
                                    <td class="w-1/6 text-right">$ </td>
                                </tr> -->
                                <tr>
                                    <td class="w-5/6 font-bold pt-4">Total</td>
                                    <td class="w-1/6 text-right font-bold pt-4">{{formattedPrice( Number(order.total) )}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- <div v-if="true" class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Información de Factura</div>
                            <a href="#" class="btn-default m-4">Ver Factura</a>                            
                        </div>
                        <div class="card-body">
                                <table class="w-full mt-2">
                                    <tr>
                                        <td class="w-1/5 text-center">Fecha</td>
                                        <td class="w-3/5 text-center">Número</td>
                                        <td class="w-1/5 text-center">Total</td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="text-center">{{}}</td>
                                        <td class="text-center">{{  }}</td>
                                        <td class="font-bold text-center">$ </td>
                                    </tr>

                                </table>
                        </div>
                    </div> -->
                    

                    <div v-if="true" class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Información del Envio</div>
                            <div class="flex"> 
                                <a href="#" class="bg-gray-100 btn-default m-4">Guia</a>
                                <!-- <a href="#" class="bg-gray-100 btn-default m-4">FC Comercial</a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="w-full mt-2">
                                <tr>
                                    <td class="w-1/5 text-center">Fecha</td>
                                    <td class="w-3/5 text-center">Trackig Number</td>
                                    <td class="w-1/5 text-center">Carrier</td>
                                    
                                </tr>
                                <tr>
                                    <td class="text-center">{{formatDateDDMMYYYY(order.created_at)}}</td>
                                    <td class="font-bold text-center">
                                        <a href="https://app.zippin.com.ar/track/947967464abf8b8533eefe8c9e860f72abff449c">01hqw65k9tpc3r5k029tpy60pk</a> 
                                    </td>
                                    <td class="text-center flex align-middle">
                                        <div >Toparco</div>
                                        <img src="https://zippincore.s3.amazonaws.com/carriers/toparco/ae26g7uhgPg4xqTH775QblR11EDNDR3SVGenRk1v.png" class="h-9"/>    

                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-span-1">
                    <div class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Información de Estados</div>
                        </div>
                        <div class="card-body">

                            <table class="w-full mt-2">
                                <tr>
                                    <td class="font-bold">
                                        General:
                                    </td>
                                    <td>
                                        {{ order.status.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">
                                        Pago:
                                    </td>
                                    <td>
                                        {{ order.status.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">
                                        Envio:
                                    </td>
                                    <td>
                                        Procesando
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                    <div class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Información de la Orden</div>
                        </div>

                        <div class="card-body">
                            <div class="card-body-section">
                                    <div class="card-body-section">
                                        {{order.client.fullname}} <br>
                                        {{order.client.cellphone}} <br>
                                        {{order.client.email}}
                                    </div> 
                            </div>
                            <div class="w-full border-b my-5"></div>
                            <div class="card-body-section">
                                <div class="card-body-section-title text-sm text-gray-400 font-bold tracking-wider mb-1">DIRECCIÓN DE ENVÍO</div>
                                    {{order.client.address}} <br>
                                    {{order.client.city}} - CP: {{order.client.zipcode}}
                                    {{order.client.state}}
                            </div>
                            <div class="w-full border-b my-5"></div>
                            <div class="card-body-section">
                                <div class="card-body-section-title text-sm text-gray-400 font-bold tracking-wider mb-1">MÉTODO DE ENVIO</div>
                                    Envío Estandar 
                            </div>
                            <div class="w-full border-b my-5"></div>
                            <div class="card-body-section">
                                <div class="card-body-section-title text-sm text-gray-400 font-bold tracking-wider mb-1">MÉTODO DE PAGO</div>
                                Nube - Tarjeta de Crédito
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>

</template>
<script>

import { defineComponent } from 'vue'
import { useFormatPrice } from '@/composables/useFormatPrice.js';
import { useFormatDate } from '@/composables/useFormatDate.js';

import { ChevronDownIcon, ChevronLeftIcon } from '@heroicons/vue/20/solid'
import { CheckCircleIcon } from '@heroicons/vue/24/outline';

import Toast from '@/Layouts/Components/Toast.vue';

export default defineComponent({
    props: {
        order: {
            type: Object,
            required: true
        }
    },
    components: {
        CheckCircleIcon,
        ChevronDownIcon,
        ChevronLeftIcon
    },
    data() {

        return {
            orders: {},
            items: [],
            open: false,
            toastMessage: "",
            labelType: "info",
            message: "",
            showToast: false,
        }
    },
    setup() {
        const formattedPrice = (price) => useFormatPrice(price);
        
        const { formatDateDDMMYYYY, formatDateDMY, formatTimeHHMM } = useFormatDate();
                
        // const useFormatDateDMYAbbrev = (date) => formatDateDMYAbbrev(date);
        return {
            formattedPrice,
            formatDateDDMMYYYY, 
            formatDateDMY, 
            formatTimeHHMM
        }
    },
    methods: {
        clearMessage() {
            this.toastMessage = ""
        },
    },
})
</script>
    