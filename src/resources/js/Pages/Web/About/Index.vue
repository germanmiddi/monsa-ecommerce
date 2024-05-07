<template>
    <div class="relative bg-white">
      <div class="lg:absolute lg:inset-0">
        <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2">
          <img :src="`/storage/${this.aboutusImg}`" class="h-56 w-full object-cover lg:absolute lg:h-full"  alt="" />
        </div>
      </div>
      <div class="relative pt-12 pb-16 px-4 sm:pt-16 sm:px-6 lg:px-8 lg:max-w-7xl lg:mx-auto lg:grid lg:grid-cols-2">
        <div class="lg:col-start-2 lg:pl-8">
          <div class="text-base max-w-prose mx-auto lg:max-w-lg lg:ml-auto lg:mr-0">
            <p v-html="this.aboutusText"></p>
          </div>
        </div>
      </div>
    </div>
  
</template>

<script>
export default {
  props:{
    content: Object
  },
  
  setup(props) {
    const aboutusText = props.content.find(item => item.element === 'text').content;
    const aboutusImg = props.content.find(item => item.element === 'img').content;
    
    return {
      aboutusText,
      aboutusImg
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