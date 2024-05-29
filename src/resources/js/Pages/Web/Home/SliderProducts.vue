<template>
    <!-- <vue-carousel :data="data"></vue-carousel> -->
    <Carousel :itemsToShow="3.95" :wrapAround="true" :transition="500" :autoplay="2000">
    <Slide v-for="slide in productItems" :key="slide">
      <div class="carousel__item">
       
            <div class="group relative">
                <div class="w-full h-56 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80 bg-gray-100 flex items-center">
                    <img style="mix-blend-mode: multiply" :src="firstImage(slide.imagen)" :alt="slide.imageAlt" class="m-auto w-2/3 h-2/3 object-center object-cover" />
                </div>   

                <h3 class="mt-4 text-sm text-gray-700">
                    <a  :href="route('product', slide.id)">
                        {{ slide.nombre }}
                    </a>
                </h3>
                <p class="mt-1 text-xl font-bold text-gray-900">$ {{ slide.precio }}</p>
            </div>
      </div>
    </Slide>

  </Carousel>
    <!-- <h1>soy el slider</h1> -->
  </template>
  
  <script>
  import { Carousel, Pagination, Slide } from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'

  export default {
    props:{
        productItems: Object,
    },
    components: {
      Carousel,
    Slide,
    Pagination,
    },
    data() {
      return {
        data: [
          '<div class="example-slide">Slide 1</div>',
          '<div class="example-slide">Slide 2</div>',
          '<div class="example-slide">Slide 3</div>',
        ],
      };
    },
    methods: {
        firstImage(imagen) {
          try {
        const imagenes = JSON.parse(imagen);
        return Array.isArray(imagenes) && imagenes.length > 0 ? `http://monsa-srl.com.ar/pedidosweb/${imagenes[0]}` : '';
      } catch (e) {
        console.error('Error parsing JSON', e);
        return '';
      }
      }
    }
    

  };
  </script>
  
  <style scoped>
  .carousel__slide {
    padding: 5px;
  }
  
  .carousel__viewport {
    perspective: 2000px;
  }
  
  .carousel__track {
    transform-style: preserve-3d;
  }
  
  .carousel__slide--sliding {
    transition: 0.5s;
  }
  
  .carousel__slide {
    opacity: 0.9;
    transform: rotateY(-20deg) scale(0.9);
  }
  
  .carousel__slide--active ~ .carousel__slide {
    transform: rotateY(20deg) scale(0.9);
  }
  
  .carousel__slide--prev {
    opacity: 1;
    transform: rotateY(-10deg) scale(0.95);
  }
  
  .carousel__slide--next {
    opacity: 1;
    transform: rotateY(10deg) scale(0.95);
  }
  
  .carousel__slide--active {
    opacity: 1;
    transform: rotateY(0) scale(1.1);
  }
  </style>