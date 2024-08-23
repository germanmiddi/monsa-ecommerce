<template>
    <div class="flex-grow min-h-full mb-12 relative">
        <!-- Fondo decorativo -->
        <div class="absolute inset-0 bg-gradient-to-b from-monsa-blue to-blue-900 w-full z-0 h-96   overflow-hidden">
            <div class="section px-6 py-20 md:py-60 w-full" style="background:url('/images/v.png'); opacity:0.05">
            </div>
        </div>
         
        <!-- Loader -->
        <div v-if="loading" class="flex justify-center items-center bg-gray-50 fixed w-full h-screen top-0 z-50"> 
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-theme-sky"></div>
        </div> 

        <!-- Contenido del post -->
        <div v-else class="relative z-10 pt-24">
            <div class="bg-white section container mx-auto rounded-xl md:rounded-2xl w-11/12 md:w-8/12 shadow">
                <div class="px-6 py-10 mb-6 w-11/12 mx-auto ">
                    <div class="col-span-7">   
                        <div class="mb-6 md:mb-14 text-xl">
                            <h3 class="text-3xl mb-3 md:text-5xl text-theme-blue font-semibold">{{post.title}}</h3>
                            <div class="text-base mb-3 text-gray-600">{{ formatFecha(post.date_published)}}</div>
                            <span v-if="post.post_category" class="inline-flex uppercase text-white text-base bg-monsa-blue py-1 px-2 rounded-sm">{{ post.post_category.name }}</span>  
                        </div> 
                        
                        <div v-if="post.image">
                            <img :src="`/storage/${post.image}`" class="w-full rounded-2xl mb-8">
                        </div>

                        <div v-html="post.content"
                             class="text-gray-600 mt-4 mb-6 font-ptserif text-xl text-justify leading-5">
                        </div>    
                    </div> 
                </div>
            </div> 

            <!-- Botón de volver -->
            <div class="mx-auto w-11/12 md:w-8/12 mt-6">
                <button @click="goBack" type="button"
                class="w-1/3 bg-monsa-blue 
                        border border-transparent rounded-md py-3 px-8 flex items-center justify-center 
                        text-base font-medium text-white hover:bg-blue-800 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-offset-gray-50 focus:ring-monsa-dark">Volver</button>
            </div>
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
            window.history.back();
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