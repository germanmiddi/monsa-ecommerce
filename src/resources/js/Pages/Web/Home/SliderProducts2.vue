<template>
    <Carousel v-bind="settings" :breakpoints="breakpoints">
      <Slide v-for="slide in productItems" :key="slide">
        
        <!-- <a class="carousel__item" @click="goUrl(slide.id)"> -->
        <div @click="goUrl(slide.id)" class="carousel__item overflow-hidden mx-2 flex flex-col items-center bg-gray-100 rounded-xl hover:cursor-pointer hover:text-monsa-blue">
            <div class="w-60 h-60 overflow-hidden">
                <img class="img-item w-full h-full object-cover" 
                     style="mix-blend-mode: multiply"
                     :src="firstImage(slide.imagen)" alt="">
            </div>
            <div class="overflow-hidden h-12 px-2 mt-4">
                <div>{{ truncateText(slide.nombre, 20) }}</div>
            </div>
            <div class="overflow-hidden h-12 px-2">
                <div class="font-extrabold text-2xl">{{ formatPrice(slide.price_public) }}</div>
            </div>
        </div>
      </Slide>
  
      <template #addons>
        <Navigation />
      </template>
    </Carousel>
  </template>
  
  <script>
  import { defineComponent } from 'vue'
  import { Carousel, Navigation, Slide } from 'vue3-carousel'
  
  import 'vue3-carousel/dist/carousel.css'
  
  export default defineComponent({
    name: 'Breakpoints',
    components: {
      Carousel,
      Slide,
      Navigation,
    },

    props:{
        productItems: Object,
    },
    
    data: () => ({
      // carousel settings
      settings: {
        itemsToShow: 1,
        snapAlign: 'center',
      },
      // breakpoints are mobile first
      // any settings not specified will fallback to the carousel settings
      breakpoints: {
        // 700px and up
        700: {
          itemsToShow: 3.5,
          snapAlign: 'center',
        },
        // 1024 and up
        1024: {
          itemsToShow: 3.5,
          snapAlign: 'start',
        },
      }
    }),
    methods: {
        firstImage(imagen) {
            try {
                const imagenes = JSON.parse(imagen);
                return Array.isArray(imagenes) && imagenes.length > 0 ? `http://monsa-srl.com.ar/pedidosweb/${imagenes[0]}` : '';
            } catch (e) {
                console.error('Error parsing JSON', e);
                return '';
            }
        },  
        goUrl(id){
            let url = route('product', id);
            window.location.href = url;
        },
        truncateText(text, length) {
            if (text.length <= length) return text;
            return text.slice(0, length) + '...';
        },    
        
        formatPrice(price_public){
            const formattedPrice = price_public.toLocaleString('es-AR', {
                    style: 'currency',
                    currency: 'ARS',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                    });
            return formattedPrice;

        }            
    }    
  })
  </script>
<style>
    .carousel__prev, .carousel__next {
        background-color: #0C41FA;
        color: white;
    }
    .carousel__prev:hover, .carousel__next:hover {
        color: white;
    }

</style>
