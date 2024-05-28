<template>
    <!-- <vue-carousel :data="data"></vue-carousel> -->
    <carousel :per-page="3">
      <img v-for="(image, index) in productItems" :key="index" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWhfV0zRyQj6tRHozJfGh_JefHyh4VoHi_clmHwJC1oQ&s" class="carousel-image">
    </carousel>
    <!-- <h1>soy el slider</h1> -->
  </template>
  
  <script>
  import Carousel from '@chenfengyuan/vue-carousel';

  export default {
    props:{
        productItems: Object,
    },
    components: {
      Carousel,
    },
    data() {

        //const mobileItems = this.sliderMobile.map(item => `<img src="/storage/${item.image}" class="w-full h-full object-center object-cover" />`);
        const Items = this.productItems.map(item => `
              <div class="group relative">
                    <div class="w-full h-56 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80 bg-gray-100 flex items-center">
                      <img src="http://monsa-srl.com.ar/pedidosweb/${JSON.parse(item.imagen)}" class="m-auto w-2/3 h-1/3 object-center object-cover" />
                    </div>                
                    <h3 class="mt-4 text-sm text-gray-700">
                        <a :href="${item.href}">
                            <span class="absolute inset-0" />
                            ${item.name }
                        </a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">${ item.color }</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">${ item.price }</p>
                </div>`
              );

      return {
        //mobileItems,
        Items,
        data: [
          '<div class="example-slide">Slide 1</div>',
          '<div class="example-slide">Slide 2</div>',
          '<div class="example-slide">Slide 3</div>',
        ],
      };
    },

  };
  </script>
  
  <style scoped>
  .example-slide {
    align-items: center;
    background-color: #666;
    color: #999;
    display: flex;
    font-size: 1.5rem;
    justify-content: center;
    min-height: 10rem;
  }
  .carousel-image {
  width: 100%;
  height: auto;
}
  </style>