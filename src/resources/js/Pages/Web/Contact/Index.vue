<!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  const colors = require('tailwindcss/colors')
  
  module.exports = {
    // ...
    theme: {
      extend: {
        colors: {
          'warm-gray': colors.warmGray,
          teal: colors.teal,
        },
      },
    },
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
    <div class="bg-white">
  
      <main class="overflow-hidden">
        <!-- Header -->
        <div class="bg-warm-gray-50">
          <div class="py-24 lg:py-32">
            <div class="relative z-10 max-w-7xl mx-auto pl-4 pr-8 sm:px-6 lg:px-8">
              <h1 class="text-4xl font-extrabold tracking-tight text-warm-gray-900 sm:text-5xl lg:text-6xl">Escribinos!</h1>
              <p class="mt-6 text-xl text-warm-gray-500 max-w-3xl">¿Necesitás repuestos para tu moto? En Monsa estamos listos para ayudarte. Venta mayorista y minorista, envios a todo el pais.<br><br> Contactanos y descubrí por qué somos líderes en repuestos de motos en Argentina.</p>
            </div>
          </div>
        </div>
  
        <!-- Contact section -->
        <section class="relative bg-white pb-52" aria-labelledby="contact-heading">
          <div class="absolute w-full h-1/2 bg-warm-gray-50" aria-hidden="true" />
          <!-- Decorative dot pattern -->
          <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <svg class="absolute z-0 top-0 right-0 transform -translate-y-16 translate-x-1/2 sm:translate-x-1/4 md:-translate-y-24 lg:-translate-y-72" width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
              <defs>
                <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                  <rect x="0" y="0" width="4" height="4" class="text-monsa-blue text-opacity-20 " fill="currentColor" />
                  <!-- <rect x="0" y="0" width="4" height="4" class="text-warm-gray-200" fill="currentColor" /> -->
                </pattern>
              </defs>
              <rect width="404" height="384" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
            </svg>
          </div>
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-white shadow-xl">
              <div class="grid grid-cols-1 lg:grid-cols-3">
                <!-- Contact information -->
                <div class="relative overflow-hidden py-10 px-6 bg-gradient-to-b from-monsa-blue to-monsa-blue sm:px-10 xl:p-12">
                <!-- <div class="relative overflow-hidden py-10 px-6 bg-gradient-to-b from-teal-500 to-teal-600 sm:px-10 xl:p-12"> -->
                  <!-- Decorative angle backgrounds -->
                  <div class="absolute inset-0 pointer-events-none sm:hidden" aria-hidden="true">
                    <svg class="absolute inset-0 w-full h-full" width="343" height="388" viewBox="0 0 343 388" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                      <path d="M-99 461.107L608.107-246l707.103 707.107-707.103 707.103L-99 461.107z" fill="url(#linear1)" fill-opacity=".1" />
                      <defs>
                        <linearGradient id="linear1" x1="254.553" y1="107.554" x2="961.66" y2="814.66" gradientUnits="userSpaceOnUse">
                          <stop stop-color="#fff" />
                          <stop offset="1" stop-color="#fff" stop-opacity="0" />
                        </linearGradient>
                      </defs>
                    </svg>
                  </div>
                  <div class="hidden absolute top-0 right-0 bottom-0 w-1/2 pointer-events-none sm:block lg:hidden" aria-hidden="true">
                    <svg class="absolute inset-0 w-full h-full" width="359" height="339" viewBox="0 0 359 339" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                      <path d="M-161 382.107L546.107-325l707.103 707.107-707.103 707.103L-161 382.107z" fill="url(#linear2)" fill-opacity=".1" />
                      <defs>
                        <linearGradient id="linear2" x1="192.553" y1="28.553" x2="899.66" y2="735.66" gradientUnits="userSpaceOnUse">
                          <stop stop-color="#fff" />
                          <stop offset="1" stop-color="#fff" stop-opacity="0" />
                        </linearGradient>
                      </defs>
                    </svg>
                  </div>
                  <div class="hidden absolute top-0 right-0 bottom-0 w-1/2 pointer-events-none lg:block" aria-hidden="true">
                    <svg class="absolute inset-0 w-full h-full" width="160" height="678" viewBox="0 0 160 678" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                      <path d="M-161 679.107L546.107-28l707.103 707.107-707.103 707.103L-161 679.107z" fill="url(#linear3)" fill-opacity=".1" />
                      <defs>
                        <linearGradient id="linear3" x1="192.553" y1="325.553" x2="899.66" y2="1032.66" gradientUnits="userSpaceOnUse">
                          <stop stop-color="#fff" />
                          <stop offset="1" stop-color="#fff" stop-opacity="0" />
                        </linearGradient>
                      </defs>
                    </svg>
                  </div>

                  <h3 class="text-lg font-medium text-white">Información de contacto</h3>
                  <p class="mt-6 text-base text-teal-50 max-w-3xl">Estamos ubicados en el corazón de CABA, listos para atender tus pedidos y consultas. Ya sea que necesites una entrega rápida en la ciudad o un envío a cualquier parte de Argentina, en Monsa tenemos la solución para vos.</p>
                  <dl class="mt-8 space-y-6">
                    <dd class="flex text-base text-teal-50">
                      <PhoneIcon class="flex-shrink-0 w-6 h-6 text-white" aria-hidden="true" />
                      <span class="ml-3">+54 011 4601-8950</span>
                    </dd>
                    <dd class="flex text-base text-teal-50">
                      <EnvelopeIcon class="flex-shrink-0 w-6 h-6 text-white" aria-hidden="true" />
                      <span class="ml-3">info@monsa-srl.com.ar</span>
                    </dd>
                  </dl>
                  <ul role="list" class="mt-8 flex space-x-12">
                    <li>
                      <a class="text-white hover:text-teal-100" href="https://www.facebook.com/monsasrl/">
                        <svg class="w-7 h-7" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                      </a>
                    </li>
                    <li>
                      <a class="text-white hover:text-teal-100" href="https://www.instagram.com/monsasrl/">
                        <svg class="w-7 h-7" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                        <!-- <svg class="w-7 h-7" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg> -->
                      </a>
                    </li>
                    <li>
                      <a class="text-white hover:text-teal-100" href="#">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-7 h-7" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                      </a>
                    </li>
                  </ul>
                </div>
  
                <!-- Contact form -->
                <div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
                  <h3 class="text-lg font-medium text-warm-gray-900">Envianos tu consulta</h3>
                  <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    <div>
                      <label for="first-name" class="block text-sm font-medium text-warm-gray-900">Nombre</label>
                      <div class="mt-1">
                        <input type="text" v-model="form.name" name="first-name" id="first-name" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md" />
                      </div>
                    </div>
                    <div>
                      <label for="email" class="block text-sm font-medium text-warm-gray-900">Email</label>
                      <div class="mt-1">
                        <input id="email" v-model="form.email" name="email" type="email" autocomplete="email" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md" />
                      </div>
                    </div>
                    <div>
                      <div class="flex justify-between">
                        <label for="phone" class="block text-sm font-medium text-warm-gray-900">Teléfono / Whatsapp</label>
                        <span id="phone-optional" class="text-sm text-warm-gray-500">Opcional</span>
                      </div>
                      <div class="mt-1">
                        <input type="text" v-model="form.phone" name="phone" id="phone" autocomplete="tel" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md" aria-describedby="phone-optional" />
                      </div>
                    </div>
                    <div class="sm:col-span-2">
                      <div class="flex justify-between">
                        <label for="message" class="block text-sm font-medium text-warm-gray-900">Mensaje</label>
                      </div>
                      <div class="mt-1">
                        <textarea id="message" v-model="form.message" name="message" rows="4" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border border-warm-gray-300 rounded-md" aria-describedby="message-max" />
                      </div>
                    </div>
                    <div v-if="showSuccessMessage" class="col-span-2  w-full rounded-md bg-green-50 p-4">
                      <div class="flex">
                        <div class="flex-shrink-0">
                          <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                          <p class="text-sm font-medium text-green-800">Mensaje enviado correctamente</p>
                        </div>
                        <div class="ml-auto pl-3">
                          <div class="-mx-1.5 -my-1.5">
                            <button @click="showSuccessMessage = ''" type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                              <span class="sr-only">Dismiss</span>
                              <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="showErrorMessage" class="col-span-2  w-full rounded-md bg-yellow-50 p-4">
                      <div class="flex">
                        <div class="flex-shrink-0">
                          <CheckCircleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                          <p class="text-sm font-medium text-yellow-800">Complete los campos requeridos</p>
                        </div>
                        <div class="ml-auto pl-3">
                          <div class="-mx-1.5 -my-1.5">
                            <button @click="showErrorMessage = ''" type="button" class="inline-flex bg-yellow-50 rounded-md p-1.5 text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600">
                              <span class="sr-only">Dismiss</span>
                              <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="sm:col-span-2 sm:flex sm:justify-end">
                      <button @click="sendMessage" class="mt-2 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-monsa-blue hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:w-auto">Enviar Mensaje</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
  
      </main>
    </div>

  </template>

<script>
import { defineComponent, h } from 'vue'
import { EnvelopeIcon, PhoneIcon, CheckCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline'

export default {
    components: {
        EnvelopeIcon,
        PhoneIcon,
        CheckCircleIcon,
        XMarkIcon,
    },
    setup() {
        return {
        }
    },
    data() {
        return {
          form: {
            name: '',
            email: '',
            phone: '',
            message: '',
          },
          showSuccessMessage: false,
          showErrorMessage: false,
        }
    },
    methods: {
        async sendMessage() {

          if(this.form.name == '' || this.form.email == '' || this.form.message == '') {
            this.showErrorMessage = true;
            return;
          }

          const url = route('contact.store');
          const response = await axios.post(url, this.form);
          
          this.showSuccessMessage = true;
          this.form.name = '';
        },
    }
}

</script>