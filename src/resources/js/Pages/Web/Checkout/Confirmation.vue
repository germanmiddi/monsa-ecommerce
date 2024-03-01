<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <!--
      This example requires updating your template:
  
      ```
      <html class="h-full bg-white">
      <body class="h-full">
      ```
    -->
    <main class="relative lg:min-h-full">
      <div class="h-80 overflow-hidden lg:absolute lg:w-1/2 lg:h-full lg:pr-4 xl:pr-12">
        <img src="/images/confirmation3.jpg" alt="TODO" class="h-full w-full object-center object-cover" />
      </div>
  
      <div>
        <div class="max-w-2xl mx-auto py-16 px-4 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 lg:py-32 lg:grid lg:grid-cols-2 lg:gap-x-8 xl:gap-x-24">
          <div class="lg:col-start-2">
            <h1 class="text-sm font-medium monsa-dark">Pago realizado</h1>
            <p class="mt-2 text-4xl font-extrabold tracking-tight text-monsa-yellow sm:text-5xl">Gracias por su compra</p>
            <!-- <p class="mt-2 text-base text-gray-500">We appreciate your order, we’re currently processing it. So hang tight and we’ll send you confirmation very soon!</p> -->
            <p class="mt-2 text-base text-gray-500">Agradecemos su pedido, actualmente lo estamos procesando. Así que manténgase tranquilo y le enviaremos la confirmación muy pronto."</p>
            <dl class="mt-16 text-sm font-medium">
              <dt class="text-gray-500">Número de seguimiento</dt>
              <dd class="mt-2 monsa-dark-light">
                <a href="https://app.zippin.com.ar/track/947967464abf8b8533eefe8c9e860f72abff449c">01hqw65k9tpc3r5k029tpy60pk</a>
              </dd>
            </dl>
            
            <ul role="list" class="mt-6 text-sm font-medium text-gray-500 border-t border-gray-200 divide-y divide-gray-200">
              <li v-for="product in products" :key="product.id" class="flex py-6 space-x-6">
                <!-- <pre> {{ product }} </pre> -->
                <img :src="imageSrc" :alt="product.imageAlt" class="flex-none w-24 h-24 bg-gray-100 rounded-md object-center object-cover" />
                <div class="flex-auto space-y-1">
                  <h3 class="text-gray-900">
                    <a href="#">{{ product.product.nombre }}</a>
                  </h3>
                </div>

                <p class="flex-none font-medium text-gray-900">{{ formattedPrice( Number(product.price) ) }}</p>
                <!-- <p class="flex-none font-medium text-gray-900">$ {{ product.price.toLocaleString('es-AR', {
                  style: 'currency',
                  currency: 'ARS',
                  minimumFractionDigits: 2, // Para incluir siempre dos dígitos decimales
                }) }}</p> -->
              </li>
            </ul>
  
            <dl class="text-sm font-medium text-gray-500 space-y-6 border-t border-gray-200 pt-6">
              <div class="flex justify-between">
                <dt>Envío</dt>
                <dd class="text-gray-900">$ {{ order.delivery_amount }}</dd>
              </div>
              <div class="flex items-center justify-between border-t border-gray-200 text-gray-900 pt-6">
                <dt class="text-base">Total</dt>
                <dd class="text-base">{{ formattedPrice( Number(order.total) ) }}</dd>
              </div>
            </dl>
  
            <dl class="mt-16 grid grid-cols-2 gap-x-4 text-sm text-gray-600">
              <div>
                <dt class="font-medium text-gray-900">Dirección de Envío</dt>
                <dd class="mt-2">
                  <address class="not-italic">
                    <span class="block">{{order.client.fullname}}</span>
                    <span class="block">{{ order.client.address }}</span>
                    <span class="block">{{ `${order.client.city} ${order.client.zip} - ${order.client.state}`}}</span>
                  </address>
                </dd>
              </div>
              <!-- <div>
                <dt class="font-medium text-gray-900">Payment Information</dt>
                <dd class="mt-2 space-y-2 sm:flex sm:space-y-0 sm:space-x-4">
                  <div class="flex-none">
                    <svg aria-hidden="true" width="36" height="24" viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg" class="h-6 w-auto">
                      <rect width="36" height="24" rx="4" fill="#224DBA" />
                      <path d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z" fill="#fff" />
                    </svg>
                    <p class="sr-only">Visa</p>
                  </div>
                  <div class="flex-auto">
                    <p class="text-gray-900">Ending with 4242</p>
                    <p>Expires 12 / 21</p>
                  </div>
                </dd>
              </div> -->
            </dl>
            
            <div class="mt-16 border-t border-gray-200 py-6 text-right">
              <a href="/tienda" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Volver a la tienda<span aria-hidden="true"> &rarr;</span></a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </template>
  
  <script>
 import { useFormatPrice } from '@/Composables/useFormatPrice.js';
 import { useCartStore } from '../../../Stores/useCartStore'

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
        products: this.order.items,
        imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_black_ml1.jpg'
      }
    },
    
    setup() {

      const formattedPrice = (price) => useFormatPrice(price);
      
      const cart = useCartStore();
      cart.clearCart();

      return { 
        formattedPrice,
      }
    }
  }
  </script>