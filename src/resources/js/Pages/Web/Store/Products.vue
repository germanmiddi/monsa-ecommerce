
<template>
    <div class="bg-white">
      <div class="max-w-2xl mx-auto py-16 px-4 sm:py-6 sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-4 lg:grid-cols-3 lg:gap-x-6">
          <div v-for="product in products" :key="product.id" 
                  class="group relative bg-white  rounded-lg flex flex-col overflow-hidden">
                  <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
                    <img :src="buildImg(product.imagen)" alt="Lorem" class="w-full h-full object-center object-cover group-hover:opacity-75" />
                  </div>
                  <div v-if="product.promo_active && product.promo_text" class="absolute mt-4 mx-8 ml-1 xl:ml-2 text-white bg-monsa-blue rounded-sm p-2 font-semibold bg-opacity-70 text-xs xl:text-sm">
                    <span class="">{{product.promo_text}}</span>
                  </div>
              <div class="flex-1 p-4 space-y-2 flex flex-col">
                <h3 class="text-sm font-medium text-gray-900 hover:underline">
                    <!-- <a :href="route(product.href)"> -->
                    <a :href="route('product', product.id)">
                    <span aria-hidden="true" class="absolute inset-0" />
                    <span v-if="this.$page.props.user" class="font-bold">{{ product.sku }} - </span>{{ product.nombre }}
                    </a>
                </h3>
                <div class="flex-1 flex flex-col justify-end">
                  <div v-if="product.promo_active && product.promo_text" class="flex justify-start  ">
                    <p class="text-lg font-medium line-through text-gray-700">$ {{ Number(product.price_public).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 }) }}</p>
                    <p class="text-xl font-bold text-gray-900 ml-2">$ {{ Number(product.promo_price).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 }) }}</p>
                  </div>
                  <p v-else class="text-xl font-bold text-gray-900">$ {{ Number(product.price_public).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 }) }}</p>
                </div>
              </div>
          </div>
          </div>
      </div>
    </div>
</template>
  
  <script>
  
  export default {
    props: {
      products: {
        type: Object,
        required: true,
      },
    },
    setup() {
      return {
        // products,
        imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_black_ml1.jpg',
      }
    },
    methods: {
      buildImg(imagen) {
        let imageArray = JSON.parse(imagen);

        if (imageArray.length > 0) {
            // Asegura que la ruta de la imagen comience siempre con una barra '/'
            const imagePath = imageArray[0].startsWith('/') ? imageArray[0] : '/' + imageArray[0];
            const img = `https://www.monsa-srl.com.ar/pedidosweb${imagePath}`;
            return img;
        } else {
            return null;
        }
      }
    }
  }
  </script>