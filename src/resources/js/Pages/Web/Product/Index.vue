
<template>
  <div class="bg-white">
      <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
          <!-- Image gallery -->
          <TabGroup as="div" class="flex flex-col-reverse">
            <!-- Image selector -->
            <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
              <TabList class="grid grid-cols-4 gap-6">
                <Tab v-for="image in product.images" :key="image.id" class="relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-offset-4 focus:ring-opacity-50" v-slot="{ selected }">
                  <span class="sr-only">
                    {{ image.name }}
                  </span>
                  <span class="absolute inset-0 rounded-md overflow-hidden">
                    <img :src="image.src" alt="" class="w-full h-full object-center object-cover" />
                  </span>
                  <span :class="[selected ? 'ring-indigo-500' : 'ring-transparent', 'absolute inset-0 rounded-md ring-2 ring-offset-2 pointer-events-none']" aria-hidden="true" />
                </Tab>
              </TabList>
            </div>
  
            <TabPanels class="w-full aspect-w-1 aspect-h-1">
              <TabPanel v-for="image in product.images" :key="image.id">
                <img :src="image.src" :alt="image.alt" class="w-full h-full object-center object-cover sm:rounded-lg" />
              </TabPanel>
            </TabPanels>
          </TabGroup>
  
          <!-- Product info -->
          <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ product.nombre }}</h1>
  
            <div class="mt-3">
              <h2 class="sr-only">Product information</h2>
              <p class="text-3xl text-gray-900">{{ formatPrice(product.precio) }}</p>
            </div>
  
            <!-- Reviews -->
            <div class="mt-3">
              <h3 class="sr-only">Reviews</h3>
              <div class="flex items-center">
                <div class="flex items-center">
                  <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[product.rating > rating ? 'text-monsa-yellow' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                </div>
                <p class="sr-only">{{ product.rating }} out of 5 stars</p>
              </div>
            </div>
  
            <div class="mt-6">
              <h3 class="sr-only">Description</h3>
              <div class="mt-5 border-t border-gray-200">
                <dl class="sm:divide-y sm:divide-gray-200">
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">MODELO</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ product.modelo }}</dd>
                  </div>
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">TALLE</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">ML</dd>
                  </div>
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">GRÁFICA</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">SOLID</dd>
                  </div>

                </dl>  
              </div>  
              <!-- <div class="text-base text-gray-700 space-y-6" v-html="product.description" /> -->
            </div>
  
            <form class="mt-6">
              <!-- Colors -->
              <div>
                <h3 class="text-sm text-gray-600">Color</h3>
  
                <RadioGroup v-model="selectedColor" class="mt-2">
                  <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>
                  <div class="flex items-center space-x-3">
                    <RadioGroupOption as="template" v-for="color in product.colors" :key="color.name" :value="color" v-slot="{ active, checked }">
                      <div :class="[color.selectedColor, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">
                        <RadioGroupLabel as="p" class="sr-only">
                          {{ color.name }}
                        </RadioGroupLabel>
                        <span aria-hidden="true" :class="[color.bgColor, 'h-8 w-8 border border-black border-opacity-10 rounded-full']" />
                      </div>
                    </RadioGroupOption>
                  </div>
                </RadioGroup>
              </div>
  
              <div class="mt-10 flex sm:flex-col1">
                <button @click.prevent="handleAddToCart"
                        class="max-w-xs flex-1 bg-monsa-yellow border border-transparent rounded-md py-3 px-8 flex items-center justify-center 
                               text-base font-medium text-monsa-dark-light hover:bg-monsa-dark-light hover:text-monsa-yellow focus:outline-none 
                               focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500 sm:w-full">Agregar al carrito</button>
  
                <button type="button" class="ml-4 py-3 px-3 rounded-md flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                  <HeartIcon class="h-6 w-6 flex-shrink-0" aria-hidden="true" />
                  <span class="sr-only">Add to favorites</span>
                </button>
              </div>
            </form>
 

          </div>
        </div>
      </div>
    </div>
  </template>
  

  
  <script>
  
  import { ref, computed } from 'vue'
  import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
  } from '@headlessui/vue'
  import { StarIcon } from '@heroicons/vue/24/solid'
  import { HeartIcon, MinusIcon, PlusIcon } from '@heroicons/vue/24/outline'
  import { useCartStore } from '../../../Stores/useCartStore'
  // import { useCart } from '@/Stores/useCartStore'

  // const product = {
  //   name: 'Cascos AGV K1 SOLID MATT BLACK ML',
  //   price: '$ 219.186',
  //   rating: 4,
  const images = [
                    {
                      id: 1,
                      name: 'CASCOS AGV K1 SOLID BLACK ML',
                      src: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_matt_black1.jpg',
                      alt: 'Angled front view with bag zipped and handles upright.',
                    },
                    {
                      id: 2,
                      name: 'CASCOS AGV K1 SOLID BLACK ML',
                      src: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_matt_black2.jpg',
                      alt: 'Angled front view with bag zipped and handles upright.',
                    },
                    {
                      id: 3,
                      name: 'CASCOS AGV K1 SOLID BLACK ML',
                      src: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_matt_black3.jpg',
                      alt: 'Angled front view with bag zipped and handles upright.',
                    },
                    {
                      id: 4,
                      name: 'CASCOS AGV K1 SOLID BLACK ML',
                      src: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_matt_black4.jpg',
                      alt: 'Angled front view with bag zipped and handles upright.',
                    },
                    // More images...
                  ]
  

  export default {
    props: {
      product: {
        type: Object,
        required: true,
      },
    },

    components: {
      Disclosure,
      DisclosureButton,
      DisclosurePanel,
      RadioGroup,
      RadioGroupLabel,
      RadioGroupOption,
      Tab,
      TabGroup,
      TabList,
      TabPanel,
      TabPanels,
      HeartIcon,
      MinusIcon,
      PlusIcon,
      StarIcon,
    },

    
    
    setup(props) {
      const selectedColor = ref()
      
      const cart = useCartStore()
      const totalPrice = computed(() => cart.calculatedTotalPrice);

      const formatPrice = (price) => {
        
        const formattedPrice = price.toLocaleString('es-AR', {
          style: 'currency',
          currency: 'ARS',
          minimumFractionDigits: 0,
          maximumFractionDigits: 0,
        });
        return formattedPrice;
      }
     
      const handleAddToCart = () => {

        cart.addToCart(props.product);
        console.log('Agregado al carrito');
        window.location.href = '/checkout';
      }

      return {
        product : {...props.product, images},
        selectedColor,
        formatPrice,
        handleAddToCart,
        totalPrice
      }
    },
    
  }
  </script>