<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <main class="bg-white px-4 pt-10 pb-24 sm:px-6 sm:pt-12 lg:px-8 lg:py-24">
      <div class="max-w-3xl mx-auto">
        <div class="max-w-xl">
          <h1 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Gracias por tu compra!</h1>
          <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Estamos procesando tu pedido</p>
          <p class="mt-4 text-base text-gray-500">Tu orden #{{ order.id }} esta siendo procesada y pronto será despachada.</p>
  
          <dl class="mt-12 text-sm font-medium">
            <dt class="text-gray-900">Número de seguimiento</dt>
            <dd class="text-indigo-600 mt-2"><a :href="order.shipments[0].tracking_url" target="_blank" class="hover:underline">{{ order.shipments[0].delivery_id }}</a></dd>
          </dl>
        </div>
  
        <section aria-labelledby="order-heading" class="mt-10 border-t border-gray-200">
          <h2 id="order-heading" class="sr-only">Tu pedido</h2>
  
          <h3 class="sr-only">Items</h3>
          <div v-for="product in products" :key="product.id" class="py-10 border-b border-gray-200 flex space-x-6">
            <img :src="product.imagen" :alt="product.imageAlt" class="flex-none w-20 h-20 object-center object-cover bg-gray-100 rounded-lg sm:w-40 sm:h-40" />
            <div class="flex-auto flex flex-col">
              <div>
                <h4 class="font-medium text-gray-900">
                  <a :href="product.href">
                    {{ product.product.nombre }}
                  </a>
                </h4>
                <p class="mt-2 text-sm text-gray-600">
                  {{ product.product.descripcion }}
                </p>
              </div>
              <div class="mt-6 flex-1 flex items-end">
                <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                  <div class="flex">
                    <dt class="font-medium text-gray-900">Cantidad</dt>
                    <dd class="ml-2 text-gray-700">
                      {{ product.quantity }}
                    </dd>
                  </div>
                  <div class="pl-4 flex sm:pl-6">
                    <dt class="font-medium text-gray-900">Precio</dt>
                    <dd class="ml-2 text-gray-700">{{ formattedPrice(product.price) }}</dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>
  
          <div class="sm:ml-40 sm:pl-6">
            <dl class="grid grid-cols-2 gap-x-6 text-sm py-10">
              <div>
                <dt class="font-medium text-gray-900">Dirección de envío</dt>
                <dd class="mt-2 text-gray-700">
                  <address class="not-italic">
                    <span class="block">{{ order.client.fullname }}</span>
                    <span class="block">{{ order.client.address }} {{ order.client.street_num }}</span>
                    <span class="block">{{ order.client.city }}, {{ order.client.state }} {{ order.client.zip }}</span>
                  </address>
                </dd>
              </div>
              <div>
                <!-- <dt class="font-medium text-gray-900">Billing address</dt>
                <dd class="mt-2 text-gray-700">
                  <address class="not-italic">
                    <span class="block">Kristin Watson</span>
                    <span class="block">7363 Cynthia Pass</span>
                    <span class="block">Toronto, ON N3Y 4H8</span>
                  </address>
                </dd> -->
              </div>
            </dl>
  
            <h4 class="sr-only">Payment</h4>
            <dl class="grid grid-cols-2 gap-x-6 border-t border-gray-200 text-sm py-10">
              <div>
                <dt class="font-medium text-gray-900">Forma de pago</dt>
                <dd class="mt-2 text-gray-700">
                  <p>NAVE</p>
                  <p>Mastercard</p>
                  
                </dd>
              </div>
              <div>
                <dt class="font-medium text-gray-900">Tipo de envío</dt>
                <dd class="mt-2 text-gray-700">
                  <p>{{ order.shipments[0].carrier_name }}</p>
                  <p>Envio en 3 días</p>
                </dd>
              </div>
            </dl>
 
            <dl class="space-y-6 border-t border-gray-200 text-sm pt-10">
              <div class="flex justify-between">
                <dt class="font-medium text-gray-900">Subtotal</dt>
                <dd class="text-gray-700">{{ formattedPrice(order.subtotal) }}</dd>
              </div>

              <div class="flex justify-between">
                <dt class="font-medium text-gray-900">Envío</dt>
                <dd class="text-gray-700">{{ formattedPrice(order.delivery_amount) }}</dd>
              </div>
              <div class="flex justify-between">
                <dt class="font-medium text-gray-900">Total</dt>
                <dd class="text-gray-900">{{ formattedPrice(order.total) }}</dd>
              </div>
            </dl>
          </div>
        </section>
      </div>
    </main>
  </template>
  
<script>
import { useFormatPrice } from '@/Composables/useFormatPrice.js';
import { useBuildImg } from '@/Composables/useBuildImg.js'
import { computed } from 'vue'

export default {
    components: {
            useFormatPrice
        },
        props: {
            order: {
                type: Object
            },
    },
    data() {
        return {
            // products: this.order.items,
            imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_black_ml1.jpg'
        }
    },

    setup(props) {
        const formattedPrice = (price) => useFormatPrice(price);

        const products = computed(() =>
          props.order.items.map((item) => {
            const imgList = JSON.parse(item.product.imagen);
            
            if (imgList.length > 0) {
              return {
                ...item,
                imagen: useBuildImg(imgList[0]),
              };
            } else {
              return {
                ...item,
                imagen: '',
              };
            }
          })
        );        
        
        
        return { 
            formattedPrice,
            products
        }
    }
}
</script>