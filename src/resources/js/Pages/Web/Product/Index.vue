
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
  
            <div class="mt-3 flex justify-between items-center">
              <div class="text-3xl text-gray-900">{{ formatPrice(product.price_public) }}</div>
              <button @click.prevent="handleAddToCart"
                        class="uppercase bg-[#232323] rounded text-white font-bold border border-transparent py-3 px-8
                               hover:border-[#232323] hover:bg-white hover:text-[#232323]">Agregar al carrito</button>
            </div>
  
            <div class="mt-6">
              <h3 class="sr-only">Description</h3>
              <div class="mt-5 border-t border-gray-200">
                <dl class="sm:divide-y sm:divide-gray-200">
                  
                  <div>
                    <p class="my-3 text-base text-gray-900">{{ product.descripcion }}</p>
                  </div>

                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">MODELO</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ product.modelo }}</dd>
                  </div>

                  <div v-for="atribute in product.atributes" :key="atribute.id" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">{{ atribute.atribute.nombre }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 uppercase">{{ atribute.valores }}</dd>
                  </div>

                </dl>  
              </div>  
              <!-- <div class="text-base text-gray-700 space-y-6" v-html="product.description" /> -->
            </div>
  
            <form class="mt-6">
              <div class="mt-10 flex sm:flex-col1">
                <button @click.prevent="handleAddToCart"
                        class="uppercase bg-[#232323] rounded text-white font-bold border border-transparent py-3 px-8
                               hover:border-[#232323] hover:bg-white hover:text-[#232323]">Agregar al carrito</button>
              </div>
            </form>
 

          </div>

          <div class="mt-20 col-span-2 border-t border-gray-200 pt-20">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-10">También te puede interesar</h2>
            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4 lg:grid-cols-4 lg:gap-x-8">
              <Item v-for="product in relatedProducts" :key="product.id" class="group relative" :product="product"></Item>

            </div>
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
  import Item from '../../../Layouts/Components/Product/Item.vue'
 

  export default {
    props: {
      product: {
        type: Object,
        required: true,
      },
      relatedProducts: {
        type: Array,
        required: true,
      },
    },

    components: {
      Item,
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

      const formatPrice = (price_public) => {
        // console.log(price_public);
        // return
        const formattedPrice = price_public.toLocaleString('es-AR', {
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

      const buildImg = (imagen) => {
          // console.log(imagen); return
          // Asegura que la ruta de la imagen comience siempre con una barra '/'
          const imagePath = imagen.startsWith('/') ? imagen : '/' + imagen;
          const img = `https://www.monsa-srl.com.ar/pedidosweb${imagePath}`;
          return img;
        
      }

      const images = () => {
        let images = [];
        if (props.product.imagen) {
          
          const items = JSON.parse(props.product.imagen)
          // console.log(items);return

          for (const item of items) {
            let id = Math.floor(Math.random() * 1000);
            images.push({
              id: id,
              src: buildImg(item)
            });
          }
        }

        return images;
      } 
      
      return {
        product : {...props.product, images: images()},
        relatedProducts: props.relatedProducts,
        selectedColor,
        formatPrice,
        handleAddToCart,
        totalPrice
      }
    },
    
  }
  </script>