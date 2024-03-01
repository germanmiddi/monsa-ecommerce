<template>
    <div class="flex-grow min-h-full mb-12">
        <div class="bg-gradient-to-b from-gray-700 to-gray-800">
            <div class="section container px-6 py-20 md:py-32  mx-auto">
                <div class="items-center lg:flex">
                    <div class="w-full flex flex-col jusctify-center text-center">
                        <!-- <h1 class="text-5xl text-theme-blue font-semibold">Novedades</h1> -->
                        <!-- <h1 class="text-5xl text-theme-blue font-semibold">{{title}}</h1>
                        <h4 class="text-gray-900 text-xl w-11/12 md:w-9/12 m-auto text-center font-normal py-6">{{subtitle}}</h4> -->
                    </div>
                </div>
            </div>
        </div>
         
        <div v-if="loading" class="flex justify-center items-center bg-gray-50 fixed w-full h-screen top-0"> 
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-theme-sky"></div>
        </div> 

        <div v-else  class="bg-white section container mx-auto -mt-20 rounded-xl md:-mt-44  md:rounded-2xl w-11/12 md:w-8/12 shadow ">
            <div class="px-6 py-10 mb-6 w-11/12 mx-auto ">
                <div class="col-span-7">   
                    <div class="mb-6 md:mb-14 text-xl">
                        <h3 class="text-3xl mb-3 md:text-5xl text-theme-blue font-semibold">{{post.title}}</h3>
                        <div class="text-base mb-3 text-gray-600">{{ formatFecha(post.date_published)}}</div>
                        <span v-if="post.post_category" class="inline-flex uppercase text-gray-800 text-base bg-monsa-yellow py-1 px-2 rounded-sm">{{ post.post_category.name }}</span>  
                    </div> 
                    
                    <div v-if="post.image">
                        <img :src="`/storage/${post.image}`" class="w-full rounded-2xl mb-8">
                    </div>

                    <div v-html="post.content"
                         class="text-gray-600 mt-4 mb-6 font-ptserif text-xl text-justify leading-5">
                    </div>    

                </div> 
                <!-- <div @click="goBack" class="cursor-pointer w-28  bg-theme-sky text-white text-sm rounded-lg py-2 px-4 flex items-center mr-4 hover:bg-theme-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    ATRAS
                  </div> -->

            </div>
        </div> 
        <div class="mx-auto w-11/12 md:w-8/12">
            <button @click="goBack" type="button"
            class="w-1/3 bg-monsa-yellow 
                    border border-transparent rounded-md py-3 px-8 flex items-center justify-center 
                    text-base font-medium text-monsa-dark-light hover:bg-monsa-dark-light hover:text-monsa-yellow 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-offset-gray-50 focus:ring-monsa-dark">Volver</button>
        </div>

    </div>  
    
</template>
<script>

import { MapPinIcon, CalendarDaysIcon } from '@heroicons/vue/20/solid'

export default {
    props:{
        post: Object
    },

    data(){
        return{
            loading: false,

        }
    },

    methods: {
        goBack(){
            this.$router.go(-1)
        },
        formatFecha(fecha){
            //formatear a  DD/MM/YYYY
            let date = new Date(fecha);
            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

    },
    created(){
        window.scrollTo(0, 0)

    }   
}
</script>

<style>

.bg-image {
  background-size: cover;
  background-position: center bottom;
}

</style>