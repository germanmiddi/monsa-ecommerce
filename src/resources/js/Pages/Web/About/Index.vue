<template>
    <div class="bg-white flex flex-col md:flex-row items-center justify-center gap-4 h-full mb-20">
       <div class="w-full md:w-1/2">
          <SliderAboutUs class="w-11/12 mx-auto rounded-lg overflow-hidden" :images="aboutusImg" />
        </div>
      <div class="w-full md:w-1/2">
          <div class="text-base px-10">
            <p v-html="this.aboutusText"></p>
          </div>
      </div>
    </div>
  
</template>

<script>
import SliderAboutUs from './SliderAboutUs.vue';
export default {
  props:{
    content: Object
  },
  components: {
    SliderAboutUs
  },
  setup(props) {
    const aboutusText = props.content.find(item => item.element === 'text').content;
    // const aboutusImg = props.content.filter(item => item.element === 'img');
    const aboutusImg = props.content.filter(item => item.element === 'img').map(item => `<img src="/storage/${item.content}" class="w-full h-96  object-center object-cover" />`);



    return {
      aboutusText,
      aboutusImg,
      
    }
  },
}
</script>

<style>
    h1 {
        font-size: 2.25rem;
        line-height: 2.5rem;
        font-weight: 800;
        color: #111827;
    }
    p {
        font-size:1.125rem;
        color: #6b7280;
        line-height: 1.75rem;
        margin-top:2rem;
        text-align: justify;
    }
</style>