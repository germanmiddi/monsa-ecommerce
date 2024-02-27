
<template>
  <div class="bg-white">
    <!-- Background color split screen for large screens -->
    <div class="hidden lg:block fixed top-0 left-0 w-1/2 h-full bg-white" aria-hidden="true" />
    <div class="hidden lg:block fixed top-0 right-0 w-1/2 h-full bg-gray-50" aria-hidden="true" />

    <header class="relative bg-white border-b border-gray-200 text-sm font-medium text-gray-700">
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="relative flex items-center sm:justify-center">
          <a href="#" class="absolute -mt-4 left-0 top-1/2 font-exo text-3xl font-extrabold text-gray-900">
            MONSA

          </a>
          <nav aria-label="Progress" class="hidden sm:block">
            <ol role="list" class="flex space-x-4">
              <li v-for="(step, stepIdx) in steps" :key="step.name" class="flex items-center">
                <a v-if="step.status === 'current'" :href="step.href" aria-current="page" class="text-indigo-600">{{
                  step.name }}</a>
                <a v-else :href="step.href">{{ step.name }}</a>
                <ChevronRightIcon v-if="stepIdx !== steps.length - 1" class="w-5 h-5 text-gray-300 ml-4"
                  aria-hidden="true" />
              </li>
            </ol>
          </nav>
          <p class="sm:hidden">Paso 2 of 4</p>
        </div>
      </div>
    </header>

    <main class="relative grid grid-cols-1 gap-x-16 max-w-7xl mx-auto lg:px-8 lg:grid-cols-2 xl:gap-x-48">
      <h1 class="sr-only">Order information</h1>
      <section aria-labelledby="summary-heading"
        class="bg-gray-50 pt-16 pb-10 px-4 sm:px-6 lg:px-0 lg:pb-16 lg:bg-transparent lg:row-start-1 lg:col-start-2">
        <div class="max-w-lg mx-auto lg:max-w-none">
          <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Resumen de la orden</h2>

          <ul role="list" class="text-sm font-medium text-gray-900 divide-y divide-gray-200">
            <li v-for="product in items" :key="product.id" class="flex items-start py-6 space-x-4">
              <img :src="product.imageSrc" :alt="product.imageAlt"
                class="flex-none w-20 h-20 rounded-md object-center object-cover" />
              <div class="flex-auto space-y-1">
                <h3>{{ product.nombre }}</h3>
                <button
                  class="border border-red-500 text-red-500 rounded-md flex items-center justify-center text-sm px-1 py-1"
                  @click="removeCart(product._id)">
                  <TrashIcon class="w-5 " />Eliminar
                </button>
              </div>
              <p class="flex-none text-base font-medium">{{ formattedPrice(product.precio) }}</p>
            </li>
          </ul>

          <dl class="hidden text-sm font-medium text-gray-900 space-y-6 border-t border-gray-200 pt-6 lg:block">
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <!-- <dd>$ {{ product.precio }}</dd> -->
            </div>

            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Envío</dt>
              <dd>$ 1.500</dd>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
              <dt class="text-base">Total</dt>
              <dd class="text-base">{{ formattedPrice(totalPrice) }}</dd>
            </div>
          </dl>

          <Popover class="fixed bottom-0 inset-x-0 flex flex-col-reverse text-sm font-medium text-gray-900 lg:hidden"
            v-slot="{ open }">
            <div class="relative z-10 bg-white border-t border-gray-200 px-4 sm:px-6">
              <div class="max-w-lg mx-auto">
                <PopoverButton class="w-full flex items-center py-6 font-medium">
                  <span class="text-base mr-auto">Total</span>
                  <span class="text-base mr-2">{{ formattedPrice(totalPrice) }}</span>
                  <ChevronUpIcon class="w-5 h-5 text-gray-500" aria-hidden="true" />
                </PopoverButton>
              </div>
            </div>

            <TransitionRoot as="template" :show="open">
              <div>
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                  enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                  leave-to="opacity-0">
                  <PopoverOverlay class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                  enter-from="translate-y-full" enter-to="translate-y-0"
                  leave="transition ease-in-out duration-300 transform" leave-from="translate-y-0"
                  leave-to="translate-y-full">
                  <PopoverPanel class="relative bg-white px-4 py-6 sm:px-6">
                    <dl class="max-w-lg mx-auto space-y-6">
                      <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Subtotal</dt>
                        <dd>{{ formattedPrice(totalPrice) }}</dd>
                      </div>

                      <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Envio</dt>
                        <dd>$ 1.500</dd>
                      </div>

                      <!-- <div class="flex items-center justify-between">
                          <dt class="text-gray-600">Taxes</dt>
                          <dd>$26.80</dd>
                        </div> -->
                    </dl>
                  </PopoverPanel>
                </TransitionChild>
              </div>
            </TransitionRoot>
          </Popover>
        </div>
      </section>

      <form class="pt-16 pb-36 px-4 sm:px-6 lg:pb-16 lg:px-0 lg:row-start-1 lg:col-start-1">
        <div class="max-w-lg mx-auto lg:max-w-none">
          <section aria-labelledby="contact-info-heading">
            <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900">Información de Contacto</h2>

            <div class="mt-6">
              <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
              <div class="mt-1">
                <input type="text" id="fullname" name="fullname" v-model="form.fullname"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
            </div>

            <div class="mt-6">
              <label for="email-address" class="block text-sm font-medium text-gray-700">Email</label>
              <div class="mt-1">
                <input type="email" id="email-address" name="email-address" v-model="form.email" autocomplete="email"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
            </div>
            <div class="mt-6">
              <label for="cellphone" class="block text-sm font-medium text-gray-700">Teléfono / Whatsapp</label>
              <div class="mt-1">
                <input type="text" id="cellphone" name="cellphone" v-model="form.cellphone" autocomplete="phone"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
            </div>

          </section>



          <section aria-labelledby="shipping-heading" class="mt-10">
            <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Dirección de Envío</h2>


            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
              <div class="sm:col-span-3">
                <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                <div class="mt-1">
                  <input type="text" id="address" name="address" v-model="form.address" autocomplete="street-address"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="addressNro" class="block text-sm font-medium text-gray-700">Nro, Timbre, Dpto.</label>
                <div class="mt-1">
                  <input type="text" id="addressNro" name="addressNro" v-model="form.addressNro"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                <div class="mt-1">
                  <input type="text" id="city" name="city" autocomplete="address-level2" v-model="form.city"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="state" class="block text-sm font-medium text-gray-700">Provincia</label>
                <div class="mt-1">
                  <input type="text" id="state" name="state" autocomplete="address-level1" v-model="form.state"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="zip" class="block text-sm font-medium text-gray-700">Código Postal</label>
                <div class="mt-1">
                  <input type="text" id="zip" name="zip" 
                        v-model="form.zip" autocomplete="zip"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>
            </div>
          </section>

          <!-- <section aria-labelledby="billing-heading" class="mt-10">
              <h2 id="billing-heading" class="text-lg font-medium text-gray-900">Facturación</h2>
  
              <div class="mt-6 flex items-center">
                <input id="same-as-shipping" name="same-as-shipping" type="checkbox" checked="" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />
                <div class="ml-2">
                  <label for="same-as-shipping" class="text-sm font-medium text-gray-900">Mismo</label>
                </div>
              </div>
            </section> -->

          <div class="mt-10 pt-6 border-t border-gray-200 sm:flex sm:items-center sm:justify-between">
            <button @click.prevent="submitCheckout" type="submit" class="w-full bg-monsa-yellow border border-transparent rounded-md shadow-sm 
                                          py-2 px-4 text-sm font-medium  
                                          text-monsa-dark-light hover:bg-monsa-dark-light hover:text-monsa-yellow
                                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 
                                          focus:ring-monsa-yellow sm:ml-6 sm:order-last sm:w-auto">
              Continuar</button>
            <p class="mt-4 text-center text-sm text-gray-500 sm:mt-0 sm:text-left">Será redirigido a la ventana del pago.
            </p>
          </div>
        </div>
      </form>
    </main>
  </div>
</template>
  
<script>

import { ref, computed } from 'vue'
import { ChevronRightIcon, ChevronUpIcon } from '@heroicons/vue/24/solid'
import { TrashIcon } from '@heroicons/vue/24/outline'
import { Popover, PopoverButton, PopoverOverlay, PopoverPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useCartStore } from '../../../Stores/useCartStore'
import { useFormatPrice } from '@/composables/useFormatPrice.js';

// const formattedPrice = useFormatPrice(price);

const steps = [
  { name: 'Carrito', href: '#', status: 'complete' },
  { name: 'Datos de envio', href: '#', status: 'current' },
  { name: 'Pago', href: '#', status: 'upcoming' },
  { name: 'Confirmacion', href: '#', status: 'upcoming' },
]
const products = [
  {
    id: 1,
    name: 'CASCOS AGV K1 SOLID BLACK ML',
    href: '#',
    price: '$ 219.186',
    color: '',
    size: 'ML',
    imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_matt_black1.jpg',
    imageAlt:
      'Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps.',
  },
  // More products...
]

export default {
  components: {
    Popover,
    PopoverButton,
    PopoverOverlay,
    PopoverPanel,
    TransitionChild,
    TransitionRoot,
    ChevronRightIcon,
    ChevronUpIcon,
    TrashIcon
  },
  setup() {

    const cart = useCartStore()
    const totalPrice = computed(() => cart.totalPrice);

    const formattedPrice = (price) => useFormatPrice(price);

    const submitCheckout = async () => {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      const url = route('checkout_process')

      let response = await axios.post(url, {
        customerDetails: form.value,
        cartItems: cart.items,
        totalPrice: totalPrice.value
      },
        {
          headers: {
            'X-CSRF-TOKEN': csrfToken // Asegúrate de que la solicitud incluya el token CSRF
          }
        })

      console.log(response.data.response.data.checkout_url)
      
      // if (response.data.response.data.checkout_url) {
      //   window.location.href = response.data.response.data.checkout_url
      // }

      return

    }

    const removeCart = (id) => {
      cart.removeItem(id)
    }

    let form = ref({
      fullname: '',
      email: '',
      cellphone: '',
      address: '',
      city: '',
      state: '',
      zip: '',
      addressNro: ''
    })

    return {
      items: cart.items,
      steps,
      products,
      totalPrice,
      formattedPrice,
      submitCheckout,
      form,
      removeCart
    }
  },
  template: 'none'
}
</script>