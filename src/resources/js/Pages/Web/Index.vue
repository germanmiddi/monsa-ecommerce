

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
    

    <section aria-labelledby="trending-heading">
        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:pt-32 lg:px-8">
            <div class="md:flex md:items-center md:justify-between mb-8">
                <h2 id="favorites-heading" class="text-3xl font-extrabold tracking-tight text-gray-900">Destacados del Mes</h2>
                <!-- <a href="#" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 md:block">Todos los destacados<span aria-hidden="true"> &rarr;</span></a> -->
            </div>

            <SliderProducts2 :productItems="products"/>

            <!-- <div class="mt-8 text-sm md:hidden">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Todos los destacados<span aria-hidden="true"> &rarr;</span></a>
            </div> -->
        </div>
    </section>

    <!-- <section>
        <CarouselProducts :productItems="products" />
    </section> -->
    <!-- <section >
        <div class="bg-monsa-blue">
            <div id="background" class="pt-48 pb-16" style="background-image:url('/images/v.png'); opacity: 0.08;">
            </div>
            <div class="relative pt-48 pb-16 sm:pb-24" style="opacity: 1;">
                            <div>
                                <h1 id="sale-heading" class="text-4xl font-extrabold tracking-tight text-white md:text-4xl">
                                    {{bannerTitle}}
                                    <br>
                                    {{bannerSubtitle}}
                                    <br>
                                    {{bannerTitleH1}}
                                </h1>
                                <div class="mt-6 text-base">
                                    <a :href="bannerLink" class="font-semibold text-monsa-yellow">Ver productos<span aria-hidden="true"> &rarr;</span></a>
                                </div>
                            </div>

                            <div class="absolute -top-32 left-1/2 transform -translate-x-1/2 sm:top-6 sm:translate-x-0">
                                <div class="ml-24 flex space-x-6 min-w-max sm:ml-3 lg:space-x-8">
                                    <div class="flex space-x-6 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                                        <div class="flex-shrink-0">
                                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/lluvia.png" alt="" />
                                        </div>

                                        <div class="mt-6 flex-shrink-0 sm:mt-0">
                                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cascos/46692-1.jpg" alt="" />
                                        </div>
                                    </div>
                                    <div class="flex space-x-6 sm:-mt-20 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                                        <div class="flex-shrink-0">
                                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cascos/46692-1.jpg" alt="" />                                            
                                        </div>

                                        <div class="mt-6 flex-shrink-0 sm:mt-0">
                                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cubierta.jpg" alt="" />
                                            
                                        </div>
                                    </div>
                                    <div class="flex space-x-6 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                                        <div class="flex-shrink-0">
                                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/cubierta.jpg" alt="" />
                                        </div>

                                        <div class="mt-6 flex-shrink-0 sm:mt-0">
                                            <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" src="/images/products/lluvia.png" alt="" />
                                        </div>
                                    </div>

                                </div>
                            </div>
            </div>    
        </div>
    </section> -->
        <!-- Fondo decorativo -->


    <div class="relative my-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-monsa-blue to-blue-900 w-full z-0 h-400px    overflow-hidden">
            <div class="section px-6 py-20 md:py-60 w-full" style="background:url('/images/v.png'); opacity:0.05">
            </div>
        </div>        

        <div class="relative pt-48 pb-16 sm:pb-24 max-w-7xl mx-auto px-4 lg:px-8 ">

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
                <h1 id="sale-heading" class="text-6xl  font-extrabold tracking-tight text-white md:text-4xl">
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




    <section>
        <div class="relative bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
            <div class="absolute inset-0">
                <div class="bg-white h-1/3 sm:h-2/3" />
                </div>
                <div class="relative max-w-7xl mx-auto">
                    <div class="text-center">
                        <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Novedades</h2>
                        <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.</p>
                    </div>
                    <div class="mt-12 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
                        <div v-for="post in posts" :key="post.title" class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover" :src="`storage/${post.image}`"  alt="" />
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <!-- <p class="text-sm font-medium text-monsa-dark">{{ post.post_category.name }}</p> -->
                                <a :href="route('blog.single', post.slug)" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 hover:text-monsa-blue">{{ post.title }}</p>
                                    
                                    <p class="mt-3 text-base text-gray-500" v-html="truncateContent(post.content)"></p>
                                </a>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-center justify-between ">
                                    <div class="bg-monsa-blue text-sm text-white px-2 py-1 rounded-sm ">
                                        <span>{{ post.post_category.name}}</span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ post.date_published }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</template>

<script>
import Slider from './Home/Slider.vue'
import SliderProducts from './Home/SliderProducts.vue'
import SliderProducts2 from './Home/SliderProducts2.vue'
import CarouselProducts from './Home/CarouselProducts.vue'

const old_posts = [
  {
    title: 'Architecto accusantium praesentium eius',
    href: '#',
    category: { name: 'Novedades', href: '#' },
    description:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
    date: 'Mar 16, 2020',
    datetime: '2020-03-16',
    imageUrl:
      'images/post-1.jpg',
    readingTime: '6 min',
    author: {
      name: 'Roel Aufderehar',
      href: '#',
      imageUrl:
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
  },
  {
    title: 'Lorem ipsum dolor sit amet consectetur',
    href: '#',
    category: { name: 'Nuevo Ingreso', href: '#' },
    description:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit facilis asperiores porro quaerat doloribus, eveniet dolore. Adipisci tempora aut inventore optio animi., tempore temporibus quo laudantium.',
    date: 'Mar 10, 2020',
    datetime: '2020-03-10',
    imageUrl:
    'images/post-1.jpg',
    readingTime: '4 min',
    author: {
      name: 'Brenna Goyette',
      href: '#',
      imageUrl:
        'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
  },
  {
    title: 'Sint harum rerum voluptatem',
    href: '#',
    category: { name: 'Lanzamiento', href: '#' },
    description:
      'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint harum rerum voluptatem quo recusandae magni placeat saepe molestiae, sed excepturi cumque corporis perferendis hic.',
    date: 'Feb 12, 2020',
    datetime: '2020-02-12',
    imageUrl:
    'images/post-1.jpg',
    readingTime: '11 min',
    author: {
      name: 'Daniela Metz',
      href: '#',
      imageUrl:
        'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
  },
]


const trendingProducts = [
		{
			id: 1,
			name: 'CASCOS AGV K1 SOLID BLACK XL',
			color: 'AGV',
			price: '$ 123.456',
			href: '#',
			imageSrc: '/images/products/cascos/46692-1.jpg',
			imageAlt: 'CASCOS AGV K1 SOLID BLACK XL',
		},
		{
			id: 1,
			name: 'RODILLERA TITANIUM - NEGRO',
			color: 'PRO TORK',
			price: '$ 22.639',
			href: '#',
			imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/repuestos%20pl%C3%A1sticos/rodilleras-pro-tork.png',
			imageAlt: '',
		},
		{
			id: 1,
			name: 'Bateria Yuasa NP7 - 12',
			color: 'YUASA',
			price: '$ 123.456',
			href: '#',
			imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/baterias/506-marca-de-agua.jpg',
			imageAlt: '',
		},
		// More products...
	]
    
export default {

    props:{
        sliderDesktop: Object,
        sliderMobile:  Object,
        brands:  Object,
        content: Object,
        posts:   Object,
        products: Object
    },

    components:{
        Slider,
        SliderProducts,
        CarouselProducts,
        SliderProducts2
    },

    setup(props) {
        const bannerTitle = props.content.find(item => item.element === 'h1').content;
        const bannerSubtitle = props.content.find(item => item.element === 'h2').content;
        const bannerLink = props.content.find(item => item.element === 'link').content;
        return {
            trendingProducts,
            bannerTitle,
            bannerSubtitle,
            bannerLink
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
    computed: {

    },

    layout: 'LayoutWeb' // Define the layout for this page
}
</script>


<style scoped>
@keyframes marquee {
  from { transform: translateX(0); }
  to { transform: translateX(-100%); }
}

@keyframes marquee2 {
  from { transform: translateX(100%); }
  to { transform: translateX(0); }
}

@keyframes marqueeright {
  from { transform: translateX(-100%); }
  to { transform: translateX(0); }
}

@keyframes marquee2right {
  from { transform: translateX(0); }
  to { transform: translateX(100%); }
}

.animate-marquee {
  animation: marquee 40s linear infinite;
}

.animate-marquee2 {
  animation: marquee2 40s linear infinite;
}

.animate-marqueeright {
  animation: marqueeright 40s linear infinite;
}

.animate-marquee2right {
  animation: marquee2right 40s linear infinite;
}
</style>