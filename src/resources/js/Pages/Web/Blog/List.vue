<template>
  <!--eslint-disable  -->
    <div class="flex-grow min-h-full mb-12 relative">
        <!-- Fondo decorativo -->
        <div class="absolute inset-0 bg-gradient-to-b from-monsa-blue to-blue-900 w-full z-0 h-96   overflow-hidden">
            <div class="section px-6 py-20 md:py-60 w-full" style="background:url('/images/v.png'); opacity:0.05">
            </div>
        </div>
        <!-- Contenido del post -->
        <div class="relative z-10 pt-24">
                <div class="flex justify-center">
                  <div class="text-4xl text-white tracking-tight font-extrabold uppercase">Novedades</div>
                </div>
        </div>
    </div>   
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative bg-white pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">

   <div class="relative max-w-7xl mx-auto">

      <div v-for="post in posts.data" :key="post.id"  class="mt-12 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
          <div class="flex-shrink-0">
            <img class="h-48 w-full object-cover" :src="`/storage/${post.image}`" alt="">
          </div>
          <div class="flex-1 bg-white p-6 flex flex-col justify-between">
            <div class="flex-1">
              <p class="text-sm font-medium text-indigo-600">
                <a href="#" class="hover:underline"> Novedades </a>
              </p>
              <a :href="route('blog.single', post.slug)" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900">{{ post.title }}</p>
                <p class="mt-3 text-base text-gray-500">{{ getExcerpt(post.content, 150) }}</p>
              </a>
            </div>
            <div class="mt-6 flex items-center">
              <div class="flex-shrink-0">
                <a href="#">
                  <span class="sr-only">Roel Aufderehar</span>
                  <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </a>
              </div>
              <div class="ml-3">
                <!-- <p class="text-sm font-medium text-gray-900">
                  <a href="#" class="hover:underline"> Roel Aufderehar </a>
                </p> -->
                <div class="flex space-x-1 text-sm text-gray-500">
                  <time datetime="2020-03-16">{{ formatFecha(post.date_published) }}</time>
                  <span aria-hidden="true"> &middot; </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
    
</template>

<script>
export default {
    props:{
        posts: {
            type: Object,
            required: true
        }
    },
    methods: {
        // Esta función toma el contenido HTML y devuelve texto plano
        stripHtml(html) {
            // Creamos un elemento div temporal
            const tempDivElement = document.createElement("div");
            // Asignamos el HTML al div
            tempDivElement.innerHTML = html;
            // Usamos textContent para obtener el texto plano
            return tempDivElement.textContent || tempDivElement.innerText || "";
        },
        // Función para obtener un extracto del texto
        getExcerpt(content, length = 100) {
            // Primero, convertimos el HTML a texto plano
            const plainText = this.stripHtml(content);
            // Luego, cortamos el texto para crear un extracto
            return plainText.length > length ? plainText.substr(0, length) + "..." : plainText;
        },
        formatFecha(fecha){
            //formatear a  DD/MM/YYYY
            let date = new Date(fecha);
            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }        
    }    
}

</script>

<style>

</style>