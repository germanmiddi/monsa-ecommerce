
<script>

import { defineComponent } from 'vue'
import { useFormatPrice } from '@/Composables/useFormatPrice.js';
import { useFormatDate } from '@/Composables/useFormatDate.js';

import { ChevronDownIcon, ChevronLeftIcon } from '@heroicons/vue/20/solid'
import { CheckCircleIcon } from '@heroicons/vue/24/outline';

import Toast from '@/Layouts/Components/Toast.vue';

export default defineComponent({
    props: {
        order: {
            type: Object,
            required: true
        },
        subtotal: {
            type: Number,
            required: true
        },
    },
    components: {
        CheckCircleIcon,
        ChevronDownIcon,
        ChevronLeftIcon
    },
    data() {

        return {
            // orders: {},
            // items: [],
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
        async getShipmentLabel() {
            try {

                const response = await axios.get(`/manager/shipments/${this.order.shipments[0].shipment_id}/documentation`, {
                                                    params: {
                                                        what: 'label',
                                                        format: 'pdf'
                                                    }
                                                });

                if (response.data && response.data.body) {
                // Crear un Blob con el contenido Base64
                    const byteCharacters = atob(response.data.body);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {type: 'application/pdf'});

                    // Crear una URL para el Blob
                    const fileURL = URL.createObjectURL(blob);

                    // Abrir el PDF en una nueva pestaña
                    window.open(fileURL, '_blank');
                } else {
                    this.toastMessage = "No se pudo obtener la etiqueta del envío.";
                    this.labelType = "error";
                }

            } catch (error) {
                console.error('Error al obtener la etiqueta:', error);
                this.toastMessage = "Error al obtener la etiqueta del envío.";
                this.labelType = "error";
            }
        },

        async getShipmentLabelZebra() {
            try {
                const response = await axios.get(`/manager/shipments/${this.order.shipments[0].shipment_id}/zebra-label`);

                if (response.data && response.data.body) {
                    // Crear un Blob con el contenido Base64
                    const byteCharacters = atob(response.data.body);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {type: 'application/zpl'});

                    // Crear un elemento <a> para descargar
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `label-${this.order.shipments[0].shipment_id}.zpl`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    this.toastMessage = "No se pudo obtener la etiqueta del envío.";
                    this.labelType = "error";
                }

            } catch (error) {
                console.error('Error al obtener la etiqueta:', error);
                this.toastMessage = "Error al obtener la etiqueta del envío.";
                this.labelType = "error";
            }
        },

        clearMessage() {
            this.toastMessage = ""
        },

        async updateStatus() {
            try {
                const response = await axios.post(`/manager/orders/${this.order.id}/updateStatus`);
                this.toastMessage = "Estado del pedido actualizado";
                this.labelType = "success";
            } catch (error) {
                console.error('Error al actualizar el estado:', error);
                this.toastMessage = "Error al actualizar el estado del pedido";
                this.labelType = "error";
            }
        },

        async requestPaymentStatus() {
            try {
                const response = await axios.post(`/manager/orders/${this.order.id}/requestPaymentStatus`);
                this.toastMessage = "Estado del pago actualizado";
                this.labelType = "success";
            } catch (error) {
                console.error('Error al actualizar el estado del pago:', error);
                this.toastMessage = "Error al actualizar el estado del pago";
                this.labelType = "error";
            }
        },

        async processDevolution() {

            const response = await axios.post(`/manager/shipments/${this.order.shipments[0].shipment_id}/processDevolution`);
            if (response.data && response.data.body) {
                this.toastMessage = "Devolución procesada";
                this.labelType = "success";
            } else {
                this.toastMessage = "Error al procesar la devolución";
                this.labelType = "error";
            }

            console.log('processDevolution');
        }
    },
})
</script>

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
                    <button @click="processDevolution" class="btn-default">
                        <span>Devolución</span>
                    </button>
                    <button v-if="this.order.payment_status != 'APPROVED'" @click="requestPaymentStatus" class="btn-default">
                        <span>Consultar Pago</span>
                        <div v-if="this.loadingPaymentStatus == true" ><Icons name="cog" class="ml-2 w-6 h-6 animate-spin"/></div>
                    </button>
                    <button v-if="this.order.order_status_id < 4" @click="updateStatus" class="btn-default">
                        <span>Finalizar</span>
                    </button>
                </div>
            </div>

            <span class="mb-4">Creado: {{formatDateDMY(order.created_at)}}</span>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2">
                    <div class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Resumen del Pedido</div>
                            <div class="p-4">{{ order.items.length }} Items</div>
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
                                    <td class="w-1/6 text-right">{{formattedPrice( Number(subtotal) )}}</td>
                                </tr>
                                <tr v-if="order.delivery_amount > 0">
                                    <td class="w-5/6">Shipping</td>
                                    <td class="w-1/6 text-right">{{formattedPrice( Number(order.delivery_amount) )}}</td>
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

                    <div v-if="order.delivery_amount > 0" class="card">
                        <div class="border-b flex justify-between items-center">
                            <div class="card-title-text">Información del Envio</div>
                            <div class="flex">
                                <button @click="getShipmentLabel" class="bg-gray-100 btn-default m-4">Guia</button>
                                <button @click="getShipmentLabelZebra" class="bg-gray-100 btn-default m-4">Guia Zebra</button>
                                <!-- <a :href="`/manager/shipments/${order.shipments[0].shipment_id}/zebra-label`" class="bg-gray-100 btn-default m-4">Guia Zebra</a> -->
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
                                    <td class="text-center">{{formatDateDDMMYYYY(order.shipments[0].created_at)}}</td>
                                    <td class="font-bold text-center">
                                        <a target="_blank" class="hover:underline" :href="order.shipments[0].tracking_url">{{ order.shipments[0].delivery_id }}</a>
                                    </td>
                                    <td class="text-center flex flex-col align-middle items-center">
                                        <div >{{ order.shipments[0].carrier_name }}</div>
                                        <img :src="order.shipments[0].carrier_logo" class="w-1/2"/>

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
                                        {{ order.payment_status }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">
                                        Envio:
                                    </td>
                                    <td v-if="order.delivery_amount > 0">
                                        {{ order.shipments[0].status_name }}
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
                                Nave - Tarjeta de Crédito
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

