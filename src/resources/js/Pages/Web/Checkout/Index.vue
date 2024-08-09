
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
      <section aria-labelledby="summary-heading"
        class="bg-gray-50 pt-16 pb-10 px-4 sm:px-6 lg:px-0 lg:pb-16 lg:bg-transparent lg:row-start-1 lg:col-start-2">
        <div class="max-w-lg mx-auto lg:max-w-none">
          <div class="flex justify-between items-center">
            <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Resumen de la orden</h2>
            <span @click="clearCart" class="hover:underline cursor-pointer text-xs uppercase">Vaciar Carrito</span>
          </div>
          
          <ul role="list" class="text-sm font-medium text-gray-900 divide-y divide-gray-200">
            <li v-for="product in items" :key="product.id" class="flex items-start py-6 space-x-4">
              <img :src="product.imagen" class="flex-none w-20 h-20 rounded-md object-center object-cover" />
              <div class="flex-auto space-y-1">
                <h3>{{ product.nombre }}</h3>
                <button
                  class="border border-red-500 text-red-500 rounded-md flex items-center justify-center text-sm px-1 py-1"
                  @click="removeCart(product._id)">
                  <TrashIcon class="w-5 " />Eliminar
                </button>
              </div>
              <p class="flex-none text-base font-medium">{{ formattedPrice(product.price_public) }}</p>
            </li>
          </ul>

          <dl class="hidden text-sm font-medium text-gray-900 space-y-6 border-t border-gray-200 pt-6 lg:block">
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <dd> {{ formattedPrice(totalPrice)}}</dd>
            </div>

            <div v-if="delivery == 0" class="flex items-center justify-between">
              <dt class="text-gray-600">
                <div @click="calcDelivery" class="hover:underline">Calcular costo de envío</div></dt>
              <dd></dd>
            </div>
            <div v-else class="flex items-center justify-between">
              <dt class="text-gray-600">Envío a domicilio</dt>
              <dd>{{ formattedPrice(delivery) }}</dd>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
              <dt class="text-base">Total</dt>
              <dd class="text-base">{{ formattedPrice(totalPricewDelivery) }}</dd>
            </div>
          </dl>

          <Popover class="fixed bottom-0 inset-x-0 flex flex-col-reverse text-sm font-medium text-gray-900 lg:hidden"
            v-slot="{ open }">
            <div class="relative z-10 bg-white border-t border-gray-200 px-4 sm:px-6">
              <div class="max-w-lg mx-auto">
                <PopoverButton class="w-full flex items-center py-6 font-medium">
                  <span class="text-base mr-auto">Total</span>
                  <span class="text-base mr-2">{{ formattedPrice(totalPricewDelivery) }}</span>
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

                      <div v-if="delivery == 0" class="flex items-center justify-between">
                        <dt class="text-gray-600">
                          <div @click="calcDelivery" class="hover:underline">Calcular costo de envío</div></dt>
                        <dd></dd>
                      </div>
                      <div v-else class="flex items-center justify-between">
                        <dt class="text-gray-600">Envío a domicilio</dt>
                        <dd>{{ formattedPrice(delivery) }}</dd>
                      </div>

                    </dl>
                  </PopoverPanel>
                </TransitionChild>
              </div>
            </TransitionRoot>
          </Popover>
        </div>
      </section>

      <form class="pt-14  pb-36 px-4 sm:px-6 lg:pb-16 lg:px-0 lg:row-start-1 lg:col-start-1">
        <a :href="route('store')" class="hover:underline text-sm">Volver a la tienda</a>
        <div class="max-w-lg mx-auto lg:max-w-none">
          <section aria-labelledby="contact-info-heading">
            <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900">Información de Contacto</h2>

            <div class="mt-6">
              <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
              <div class="mt-1">
                <input type="text" id="fullname" name="fullname" v-model="form.fullname"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p v-if="v$.form.fullname.$error" class="text-red-600 text-sm mt-1">{{ v$.form.fullname.$errors[0].$message }}</p>
                </div>
            </div>

            <div class="mt-6">
              <label for="email-address" class="block text-sm font-medium text-gray-700">Email</label>
              <div class="mt-1">
                <input type="email" id="email-address" name="email-address" v-model="form.email" autocomplete="email"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p v-if="v$.form.email.$error" class="text-red-600 text-sm mt-1">{{ v$.form.email.$errors[0].$message }}</p>
              </div>
            </div>
            <div class="mt-6">
              <label for="cellphone" class="block text-sm font-medium text-gray-700">Teléfono / Whatsapp</label>
              <div class="mt-1">
                <input type="text" id="cellphone" name="cellphone" v-model="form.cellphone" autocomplete="phone"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p v-if="v$.form.cellphone.$error" class="text-red-600 text-sm mt-1">{{ v$.form.cellphone.$errors[0].$message }}</p>                  
              </div>
            </div>
            
            <div class="mt-6">
              <label for="document" class="block text-sm font-medium text-gray-700">Documento</label>
              <div class="mt-1">
                <input type="text" id="document" name="document" v-model="form.document" autocomplete="document"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p v-if="v$.form.document.$error" class="text-red-600 text-sm mt-1">{{ v$.form.document.$errors[0].$message }}</p>
                </div>
            </div>

            <div class="mt-6">
              <div class="relative flex items-start">
                <div class="flex items-center h-5">
                  <input id="check_factura" v-model="form.checkFactura" aria-describedby="check_factura" name="check_factura" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                  <label for="label_check_factura" class="font-medium text-gray-700">Requiere Factura A</label>
                  <p id="sublabel_check_factura-description" class="text-gray-500 mb-0">Si desea factura A, debe indicar el CUIT.</p>
                </div>
              </div>

            </div>
            <div class="mt-6">
              <label for="cuit" class="block text-sm font-medium text-gray-700">CUIT</label>
              <div class="mt-1">
                <input type="text" id="cuit" name="cuit" v-model="form.cuit" autocomplete="cuit"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p v-if="v$.form.cuit.$error" class="text-red-600 text-sm mt-1">{{ v$.form.cuit.$errors[0].$message }}</p>
                </div>

            </div>

          </section>


          <section aria-labelledby="shipping-heading" class="mt-10 pt-6 border-t border-gray-200">
            <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Dirección de Envío</h2>


            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
              <div class="sm:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                <div class="mt-1">
                  <input type="text" id="address" name="address" v-model="form.address" autocomplete="street-address"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <p v-if="v$.form.address.$error" class="text-red-600 text-sm mt-1">{{ v$.form.address.$errors[0].$message }}</p>
                </div>
              </div>

              <div>
                <label for="addressNro" class="block text-sm font-medium text-gray-700">Nro.</label>
                <div class="mt-1">
                  <input type="text" id="addressNro" name="addressNro" v-model="form.addressNro"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <p v-if="v$.form.addressNro.$error" class="text-red-600 text-sm mt-1">{{ v$.form.addressNro.$errors[0].$message }}</p>                    
                </div>
              </div>

              <div class="sm:col-span-3">
                <label for="addressExtras" class="block text-sm font-medium text-gray-700">Timbre, Dpto, Otros</label>
                <div class="mt-1">
                  <input type="text" id="addressExtras" name="addressExtras" v-model="form.addressExtras"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
              </div>

              <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                <div class="mt-1">
                  <input type="text" id="city" name="city" autocomplete="address-level2" v-model="form.city"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <p v-if="v$.form.city.$error" class="text-red-600 text-sm mt-1">{{ v$.form.city.$errors[0].$message }}</p>
                </div>
              </div>

              <div>
                <label for="state" class="block text-sm font-medium text-gray-700">Provincia</label>
                <div class="mt-1">
                  <input type="text" id="state" name="state" autocomplete="address-level1" v-model="form.state"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <p v-if="v$.form.state.$error" class="text-red-600 text-sm mt-1">{{ v$.form.state.$errors[0].$message }}</p>
                </div>
              </div>

              <div>
                <label for="zip" class="block text-sm font-medium text-gray-700">Código Postal</label>
                <div class="mt-1">
                  <input type="text" id="zip" name="zip" 
                        v-model="form.zip" autocomplete="zip"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p v-if="v$.form.zip.$error" class="text-red-600 text-sm mt-1">{{ v$.form.zip.$errors[0].$message }}</p>
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
                                          <Icons v-if="loading" name="loading" class="w-5 h-5"> </Icons>
                                          <label v-else>Continuar</label> 
            </button>
            <p class="mt-4 text-center text-sm text-gray-500 sm:mt-0 sm:text-left">Será redirigido a la ventana del pago.
            </p>
          </div>
        </div>
      </form>
    </main>
  </div>
</template>
  
<script>

import { ref, computed, watch } from 'vue'
import { ChevronRightIcon, ChevronUpIcon } from '@heroicons/vue/24/solid'
import { TrashIcon } from '@heroicons/vue/24/outline'
import { Popover, PopoverButton, PopoverOverlay, PopoverPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useCartStore } from '../../../Stores/useCartStore'
import { useFormatPrice } from '@/Composables/useFormatPrice.js'
import { useBuildImg } from '@/Composables/useBuildImg.js'
import Icons from '@/Layouts/Components/Icons.vue'

import useVuelidate from '@vuelidate/core';
import { required, email, helpers } from '@vuelidate/validators';


const steps = [
  { name: 'Carrito', href: '#', status: 'complete' },
  { name: 'Datos de envio', href: '#', status: 'current' },
  { name: 'Pago', href: '#', status: 'upcoming' },
  { name: 'Confirmacion', href: '#', status: 'upcoming' },
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
    TrashIcon,
    Icons
  },
  setup() {

    const cart = useCartStore()
    const totalPrice = computed(() => cart.totalPrice);
    const delivery = computed(() => cart.delivery);
    const totalPricewDelivery = computed(() => cart.totalPricewDel);
    const formattedPrice = (price) => useFormatPrice(price);
    const loading = ref(false)

    const form = ref({
      fullname: '',
      email: '',
      cellphone: '',
      address: '',
      city: '',
      state: '',
      zip: '',
      addressNro: '',
      addressExtras: '',
      document: '',
      cuit: '',
      checkFactura: false
    });

    const rules = {
      form: {
        fullname: { required: helpers.withMessage('El nombre es obligatorio', required) },
        email: { 
          required: helpers.withMessage('El email es obligatorio', required),
          email: helpers.withMessage('Por favor, ingrese un email válido', email)
        },
        cellphone: { required: helpers.withMessage('El teléfono es obligatorio', required) },
        document: { required: helpers.withMessage('El documento es obligatorio', required) },
        cuit: { 
          required: helpers.withMessage('El CUIT es obligatorio cuando se requiere factura A', (value) => {
            return !form.value.checkFactura || !!value
          })
        },          
        address: { required: helpers.withMessage('La dirección es obligatoria', required) },
        addressNro: { required: helpers.withMessage('El Nro es obligatorio', required) },
        city: { required: helpers.withMessage('La ciudad es obligatoria', required) },
        state: { required: helpers.withMessage('La provincia es obligatoria', required) },
        zip: { required: helpers.withMessage('El código postal es obligatorio', required) },
     
      }
    }

    const v$ = useVuelidate(rules, { form })

    const submitCheckout = async () => {
      const isFormCorrect = await v$.value.$validate()

      if (isFormCorrect) {
        loading.value = true
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
        const url = route('checkout_process')
        try {

          let response = await axios.post(url, {  customerDetails: form.value,
                                                  cartItems: cart.items,
                                                  totalPrice: totalPricewDelivery.value
                                                },
                                                {
                                                  headers: {
                                                            'X-CSRF-TOKEN': csrfToken 
                                                          }
                                                })
        
          if (response.data.payment.data.checkout_url) {
            cart.clearCart()
            console.log(response.data.payment.data.checkout_url)
            window.location.href = response.data.payment.data.checkout_url
          }
        } catch (error) {
          console.error('Error during checkout:', error)
          // Handle error (e.g., show error message to user)
        } finally {
          loading.value = false
        }
        
      }      
    }

    const removeCart = (id) => {
      cart.removeItem(id)
    }

    const items = computed(() =>
      cart.items.map((item) => {
        const imgList = JSON.parse(item.imagen);
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
    

    const calcDelivery = async() => {
      loading.value = true
      const post = route('checkout.calcDelivery')
      try {
        const params = {...form.value, items: cart.items, total: cart.totalPrice};
        const response = await axios.post(post, { form: params })
        const data = response.data
              
        if (response.status == 200) {
          console.log(data.price)
          cart.setDelivery(data.price)
        }
      } catch (error) {
        console.error('Error calculating delivery:', error)
        // Handle error (e.g., show error message to user)
      } finally {
        loading.value = false
      }
    }

    const clearCart = () => {
      cart.clearCart()
    }

    // Watch for changes in the zip code
    watch(() => form.value.zip, (newZip) => {
      if (newZip.length === 4) {
        calcDelivery()
      } else if (newZip.length > 4) {
        // Reset delivery cost if zip code changes after calculation
        cart.setDelivery(0)
      }
    })    

    return {
      v$,
      items,
      delivery,
      steps,
      totalPrice,
      formattedPrice,
      submitCheckout,
      totalPricewDelivery,
      form,
      removeCart,
      loading,
      calcDelivery,
      clearCart,
    }
  },
  template: 'none'
}
</script>