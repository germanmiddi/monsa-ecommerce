<script setup>
import { ref, onMounted,computed } from 'vue';
import Products from '../Store/Products.vue';

const props = defineProps({
    category: Object,
    products: Array,
});

const loading = ref(false);

const goBack = () => {
    // Si hay historial, volver atrás, sino ir a la tienda
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = route('store');
    }
}

onMounted(() => {
    window.scrollTo(0, 0);
});


const bgCategory = computed(() => {
    return props.category.image;
});

</script>

<template>
    <div class="flex-grow min-h-full mb-12 relative bg-black">
        <!-- Fondo decorativo -->
        <div v-if="!bgCategory" class="absolute inset-0 bg-gradient-to-b from-monsa-blue to-blue-900 w-full z-0 h-96 overflow-hidden">
            <div class="section px-6 py-20 md:py-60 w-full" style="background:url('/images/v.png'); opacity:0.05">
            </div>
        </div>
        <div v-else class="bg-image w-full h-96 flex items-center justify-center" :style="`background: radial-gradient(circle, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.5) 100%), url('/storage/${bgCategory}'); background-size: cover; background-position: center;`">

            <div class="section container mx-auto rounded-xl md:rounded-2xl w-11/12 md:w-10/12 shadow mb-8">
                    <div class="px-6 py-10 w-11/12 mx-auto">
                        <div class="text-center mb-6">
                            <h1 class="text-5xl md:text-5xl text-theme-blue font-semibold mb-4 text-white">
                                {{ category.name }}
                            </h1>

                            <div v-if="category.description" class="text-lg text-white max-w-3xl mx-auto text-center">
                                {{ category.description }}
                            </div>
                        </div>
                    </div>
                </div>
        </div>



        <!-- Loader -->
        <div v-if="loading" class="flex justify-center items-center bg-gray-50 fixed w-full h-screen top-0 z-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-theme-sky"></div>
        </div>

        <!-- Contenido de la categoría -->
        <div v-else class="relative z-10 pt-24">
            <!-- Productos de la categoría -->
            <div v-if="products.length > 0" class="section container mx-auto w-11/12 md:w-10/12 mt-20">
                <Products :products="products" />
            </div>

            <!-- Mensaje cuando no hay productos -->
            <div v-else class="bg-white section container mx-auto rounded-xl md:rounded-2xl w-11/12 md:w-10/12 shadow">
                <div class="px-6 py-20 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m0 0V9a2 2 0 012-2h2m0 0V6a2 2 0 012-2h2.586a1 1 0 01.707.293l2.414 2.414A1 1 0 0016 7.414V9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay productos disponibles</h3>
                    <p class="text-gray-500">Esta categoría no tiene productos disponibles en este momento.</p>
                </div>
            </div>

            <!-- Botón de volver -->
            <div class="mx-auto w-11/12 md:w-10/12 mt-6">
                <button @click="goBack" type="button"
                    class="bg-monsa-blue border border-transparent rounded-md py-3 px-8 flex items-center justify-center
                           text-base font-medium text-white hover:bg-blue-800
                           focus:outline-none focus:ring-2 focus:ring-offset-2
                           focus:ring-offset-gray-50 focus:ring-monsa-dark transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver
                </button>
            </div>
        </div>
    </div>
</template>



<style scoped>
.bg-image {
    background-size: cover;
    background-position: center bottom;
}
</style>
