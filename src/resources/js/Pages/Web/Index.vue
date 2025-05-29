

<template>
    <!-- eslint-disable -->
    <!-- Hero section -->

    <!-- <div class="flex w-full h-2/3 ">
        <img class="w-full h-full object-center object-cover" src="/images/slide1.jpg" />
    </div> -->
    <Slider :sliderMobile="sliderMobile" :sliderDesktop="sliderDesktop" :isMobile="isMobile"/>

    <!-- <div v-if="isMobile">

        <img v-for="item in sliderMobile" :src="`/storage/${item.image}`" class="w-full h-full object-center object-cover" />
    </div>
    <div v-else >
        <img v-for="item in sliderDesktop" :src="`/storage/${item.image}`" class="w-full h-full object-center object-cover" />
    </div> -->

    <section aria-labelledby="trending-heading" class="relative" v-if="products.length > 0">
        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:pt-32 lg:px-8">
            <div class="flex h-[353px] "> <!-- Set a fixed height or use h-screen for full viewport height -->
            <!-- Primer contenedor que ocupa todo el alto -->
            <div class="hidden sm:flex w-1/6 bg-cover bg-center mr-4 flex-shrink-0 items-center justify-center rounded-xl text-white font-bold text-xl
                        hover:bg-left-top transition-all duration-300"
                 style="background-image: url('images/banner-moto-1.png');">
                <span class="bg-black bg-opacity-50 p-2 text-center text-3xl">Productos<br>Destacados</span>
            </div>
            <!-- Slider ocupa el resto del ancho -->
            <!-- <div class="w-full sm:w-5/6 overflow-hidden"> -->
            <div class="w-full sm:w-5/6">
                <SliderProducts2 :productItems="products" class="h-full"/>
            </div>
            </div>
        </div>
    </section>

    <div class="relative my-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-monsa-blue to-blue-900 w-full z-0 h-400px    overflow-hidden">
            <div class="section px-6 py-20 md:py-60 w-full" style="background:url('/images/v.png'); opacity:0.05">
            </div>
        </div>
        <div class="relative py-40 sm:py-24 max-w-7xl mx-auto px-4 lg:px-8 ">
            <div class="absolute -top-32 left-1/2 transform -translate-x-1/2 sm:top-6 sm:translate-x-0">
                <div class="ml-24 flex space-x-6 min-w-max sm:ml-3 lg:space-x-8">
                    <div class="flex space-x-6 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                        <div class="flex-shrink-0 opacity-30 ">
                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/lluvia.png" alt="" />
                        </div>
                        <div class="mt-6 flex-shrink-0 sm:mt-0  opacity-30">
                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cascos/46692-1.jpg" alt="" />
                        </div>
                    </div>
                    <div class="flex space-x-6 sm:-mt-20 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                        <div class="flex-shrink-0 opacity-30">
                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cascos/46692-1.jpg" alt="" />
                        </div>
                        <div class="mt-6 flex-shrink-0 sm:mt-0 opacity-30">
                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cubierta.jpg" alt="" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="isolate opacity-100 text-center">
                <div class=" rounded-xl mx-auto py-10 max-w-4xl promo-banner" >
                    <h1 id="sale-heading" class="text-6xl  font-extrabold tracking-tight text-white">
                        {{bannerTitle}}
                        <br>
                        {{bannerSubtitle}}
                        <br>
                        {{bannerTitleH1}}
                    </h1>
                    <div class="mt-6 text-base w-full flex items-center justify-center  ">
                        <a :href="bannerLink" class="font-semibold text-white bg-monsa-blue rounded-xl px-4 py-3">
                            <div class="" >Ver productos</div>
                        </a>
                    </div>

                </div>
            </div>


        </div>
    </div>

    <section class="my-32">
        <Vue3Marquee :pause-on-hover="true">
            <div class="bg-gray-100 border border-gray-200 rounded-xl w-48 mx-5 overflow-hidden" v-for="brand in randomBrands" :key="brand">
                <img :src="`/storage/${brand.image}`"  />
            </div>
        </Vue3Marquee>

        <Vue3Marquee :direction="'reverse'" class="mt-10" :pause-on-hover="true">
            <div class="bg-gray-100 border border-gray-200 rounded-xl w-48 mx-5 overflow-hidden" v-for="brand in randomBrands2" :key="brand">
                <img :src="`/storage/${brand.image}`"  />
            </div>
        </Vue3Marquee>

    </section>

    <section>
        <div class="relative bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
            <div class="absolute inset-0">
                <div class="bg-white h-1/3 sm:h-2/3" />
                </div>
                <div class="relative max-w-7xl mx-auto">
                    <div class="text-center">
                        <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Novedades</h2>
                    </div>
                    <div class="mt-12 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
                        <div v-for="post in posts" :key="post.title" class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover" :src="`storage/${post.image}`"  alt="" />
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <a :href="route('blog.single', post.slug)" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 hover:text-monsa-blue">{{ post.title }}</p>

                                    <p class="mt-3 text-base text-gray-500 break-words whitespace-normal" v-html="truncateContent(post.content)"></p>
                                </a>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-center justify-between ">
                                    <div class="bg-monsa-blue text-sm text-white px-2 py-1 rounded-sm ">
                                        <span>{{ post.post_category.name}}</span>
                                    </div>
                                    <div class="text-sm text-gray-500 flex items-center gap-2">
                                        <CalendarIcon class="w-4 h-4" /> {{ post.date_published }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <Popup :content="popupData" />
</template>

<script>
import Slider from './Home/Slider.vue'
import SliderProducts from './Home/SliderProducts.vue'
import SliderProducts2 from './Home/SliderProducts2.vue'
import CarouselProducts from './Home/CarouselProducts.vue'
import { Vue3Marquee } from 'vue3-marquee'
import { CalendarIcon } from '@heroicons/vue/24/solid'
import Popup from '@/Pages/Web/Popup.vue'

export default {
    props:{
        sliderDesktop: Object,
        sliderMobile:  Object,
        brands:  Object,
        content: Object,
        posts:   Object,
        products: Object,
        popupData: Object
    },

    components:{
        Slider,
        SliderProducts,
        CarouselProducts,
        SliderProducts2,
        Vue3Marquee,
        CalendarIcon,
        Popup
    },

    setup(props) {
        const bannerTitle = props.content.find(item => item.element === 'h1').content;
        const bannerSubtitle = props.content.find(item => item.element === 'h2').content;
        const bannerLink = props.content.find(item => item.element === 'link').content;
        return {
            bannerTitle,
            bannerSubtitle,
            bannerLink
        }
	},
    computed: {
        randomBrands() {
            return [...this.brands].sort(() => Math.random() - 0.5);
        },
        randomBrands2() {
            return [...this.brands].sort(() => Math.random() - 0.5);
        }
    },
    data() {
        return {

            isMobile: false, // Estado para controlar si es móvil o no
        }
    },
    methods:{
        checkMobile() {
            this.isMobile = window.innerWidth < 768; // Asumiendo 768px como punto de corte para móvil
        },

        truncateContent(htmlContent) {
            const div = document.createElement("div");
            div.innerHTML = htmlContent;
            let textContent = div.textContent || div.innerText || "";

            // Trunca a 200 caracteres y agrega elipsis si el contenido es más largo
            if (textContent.length > 200) {
                textContent = textContent.substr(0, 150) + "...";
            }

            // Opcional: Convertir texto truncado de nuevo a HTML si es necesario
            // En este caso, solo estamos retornando texto, por lo que no es necesario
            return textContent;
        }
    },
    // created() {
    //   this.getHomeData()
    // },
    mounted() {
        this.checkMobile(); // Comprobar al montar
        window.addEventListener('resize', this.checkMobile); // Añadir listener para cambios de tamaño
    },
    beforeUnmount() { // o `destroyed` para Vue 2
        window.removeEventListener('resize', this.checkMobile); // Limpiar listener
    },

    layout: 'LayoutWeb' // Define the layout for this page
}
</script>

<style>
.promo-banner {
    background-color: rgba(0, 0, 0, 0.2);
    border: none;
}

</style>