<template>
  <vue-carousel :data="images" :controls="true"></vue-carousel>
</template>


<script>
import VueCarousel from '@chenfengyuan/vue-carousel';

export default ({
  name: 'SliderAboutUs',
  components: {
    VueCarousel
  },

  props: {
    images: Object,
  },

  data: () => ({

  }),
  methods: {

  }
})
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
