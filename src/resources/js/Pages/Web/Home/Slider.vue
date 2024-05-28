<template>
    <!-- <vue-carousel :data="data"></vue-carousel> -->
    <carousel v-if="isMobile" :data="mobileItems"></carousel>

    <vue-carousel v-else :data="desktopItems"></vue-carousel>
    
    <!-- <h1>soy el slider</h1> -->
  </template>
  
  <script>
  import VueCarousel from '@chenfengyuan/vue-carousel';

  export default {
    props:{
        sliderMobile: Object,
        sliderDesktop: Object,
        isMobile: Boolean,
    },
    components: {
      VueCarousel,
    },
    data() {

        const mobileItems = this.sliderMobile.map(item => `<img src="/storage/${item.image}" class="w-full h-full object-center object-cover" />`);
        const desktopItems = this.sliderDesktop.map(item => `<img src="/storage/${item.image}" class="w-full h-full object-center object-cover" />`);

      return {
        mobileItems,
        desktopItems,
        data: [
          '<div class="example-slide">Slide 1</div>',
          '<div class="example-slide">Slide 2</div>',
          '<div class="example-slide">Slide 3</div>',
        ],
      };
    },

  };
  </script>
  
  <style>
  .example-slide {
    align-items: center;
    background-color: #666;
    color: #999;
    display: flex;
    font-size: 1.5rem;
    justify-content: center;
    min-height: 10rem;
  }
  </style>