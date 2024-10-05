<!-- This example requires Tailwind CSS v2.0+ -->
<template>
   <transition name="slide-fade">
     <div v-if="message && this.visible" class="rounded-md bg-green-100 p-4 border border-green-600 w-full mx-auto transform mt-2">
       <div class="flex">
         <div class="flex-shrink-0">
           <CheckCircleIcon class="h-5 w-5 text-green-800" aria-hidden="true" />
         </div>
         <div class="ml-3">
           <div class="text-sm font-medium text-green-800">{{message}}</div>
         </div>
         <div class="ml-auto pl-3">
           <div class="-mx-1.5 -my-1.5">
             <button @click="visible=false" type="button" class="inline-flex rounded-md p-1.5 text-green-800 ">
               <XMarkIcon class="h-5 w-5" aria-hidden="true" />
             </button>
           </div>
         </div>
       </div>
     </div>
   </transition>
</template>
  
  <script>
  import {CheckCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline'
  
  export default {
    components: {
      CheckCircleIcon,
      XMarkIcon,
    },
    props:{
        message: String
    },
    watch:{
            message:{
                handler:function(){
                    this.visible = true
                    if(this.timeOut){
                        clearTimeout(this.timeOut)
                    }
                    this.timeOut = setTimeout(()=> { 
                        this.visible = false
                        this.$emit("clear")
                        }, 3000)
                },
                deep:true
            }
        },
        data(){
            return{
                visible:false,
                timeOut: null
            }
        },

  }
  </script>
  <style>
  /*
  Enter and leave animations can use different
  durations and timing functions.
  */
  .slide-fade-enter-active {
      transition: all 0.3s ease-out;
  }

  .slide-fade-leave-active {
      transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
  }

  .slide-fade-enter-from,
  .slide-fade-leave-to {
      transform: translateY(30px); /* Cambiado de translateX a translateY */
      opacity: 0;
  }
</style>