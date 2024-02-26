

<template>
    <!-- eslint-disable -->
    <!-- Hero section -->

    <div class="flex w-full h-2/3 ">      
        <img class="w-full h-full object-center object-cover" src="/images/slide1.jpg" />
    </div>

    <section aria-labelledby="trending-heading">
        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:pt-32 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <h2 id="favorites-heading" class="text-3xl font-extrabold tracking-tight text-gray-900">Destacados del Mes</h2>
                <a href="#" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 md:block">Todos los destacados<span aria-hidden="true"> &rarr;</span></a>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                <!-- <div v-for="product in trendingProducts" :key="product.id" class="group relative">
                    <div class="w-full h-56 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80 bg-gray-100">
                        <img style="mix-blend-mode:multiply" :src="product.imageSrc" :alt="product.imageAlt" class="m-auto w-1/2 h-1/2 object-center object-cover" />
                    </div> -->
                    <div v-for="product in trendingProducts" :key="product.id" class="group relative">
                        <div class="w-full h-56 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80 bg-gray-100 flex items-center">
                            <img style="mix-blend-mode: multiply" :src="product.imageSrc" :alt="product.imageAlt" class="m-auto w-2/3 h-2/3 object-center object-cover" />
                        </div>                
                    <h3 class="mt-4 text-sm text-gray-700">
                        <a :href="product.href">
                            <span class="absolute inset-0" />
                            {{ product.name }}
                        </a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>
                </div>
            </div>

            <div class="mt-8 text-sm md:hidden">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Todos los destacados<span aria-hidden="true"> &rarr;</span></a>
            </div>
        </div>
    </section>

    <section>
    <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="bg-white">
            <div class="pt-32 overflow-hidden sm:pt-14">
                <div class="bg-gray-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="relative pt-48 pb-16 sm:pb-24">
                            <div>
                                <h2 id="sale-heading" class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">
                                    Liquidación.
                                    <br />
                                    Hasta 50% off.
                                </h2>
                                <div class="mt-6 text-base">
                                    <a href="#" class="font-semibold text-monsa-yellow">Ver productos<span aria-hidden="true"> &rarr;</span></a>
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
                </div>
            </div>
        </div>
    </section>  

    <section>
        <div class="bg-white">
            <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:py-16 lg:px-8">
                <h2 class="text-3xl mx-auto tracking-tight font-extrabold text-gray-900 sm:text-4xl">Nuestras Marcas</h2>
                
                <div class="mt-12 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-8">
                    <div class="col-span-1 flex justify-center items-center py-5 px-6 bg-gray-50">
                        <img class="max-h-20" style="mix-blend-mode: multiply;" src="https://www.monsa-srl.com.ar/pedidosweb/resources/img/marcas/yuasa.png" alt="Workcation" />
                    </div>
                    <div class="col-span-1 flex justify-center items-center py-5 px-6 bg-gray-50">
                        <img class="max-h-20" style="mix-blend-mode: multiply;" src="https://www.monsa-srl.com.ar/pedidosweb/resources/img/marcas/delta.jpg" alt="Mirage" />
                    </div>
                    <div class="col-span-1 flex justify-center items-center py-5 px-6 bg-gray-50">
                        <img class="max-h-20" style="mix-blend-mode: multiply;" src="https://tailwindui.com/img/logos/tuple-logo-gray-400.svg" alt="Tuple" />
                    </div>
                    <div class="col-span-1 flex justify-center items-center py-5 px-6 bg-gray-50">
                        <img class="max-h-24" style="mix-blend-mode: multiply;" src="https://www.monsa-srl.com.ar/pedidosweb/resources/img/marcas/metzeler.jpg" alt="Laravel" />
                    </div>
                    <div class="col-span-1 flex justify-center items-center py-5 px-6 bg-gray-50">
                        <img class="max-h-20" style="mix-blend-mode: multiply;" src="https://tailwindui.com/img/logos/statamic-logo-gray-400.svg" alt="Statamic" />
                    </div>
                    <div class="col-span-1 flex justify-center items-center py-5 px-6 bg-gray-50">
                        <img class="max-h-24" style="mix-blend-mode: multiply;" src="https://www.monsa-srl.com.ar/pedidosweb/resources/img/marcas/riffel.jpg" alt="StaticKit" />
                    </div>                    
                </div>
            </div>
        </div>
    </section>

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
                    <img class="h-48 w-full object-cover" :src="post.imageUrl" alt="" />
                </div>
                <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                    <div class="flex-1">
                    <p class="text-sm font-medium text-monsa-dark">
                        <a :href="post.category.href" class="hover:underline">
                        {{ post.category.name }}
                        </a>
                    </p>
                    <a :href="post.href" class="block mt-2">
                        <p class="text-xl font-semibold text-gray-900">
                        {{ post.title }}
                        </p>
                        <p class="mt-3 text-base text-gray-500">
                        {{ post.description }}
                        </p>
                    </a>
                    </div>
                    <!-- <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <a :href="post.author.href">
                            <span class="sr-only">{{ post.author.name }}</span>
                            <img class="h-10 w-10 rounded-full" :src="post.author.imageUrl" alt="" />
                            </a>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                            <a :href="post.author.href" class="hover:underline">
                                {{ post.author.name }}
                            </a>
                            </p>
                            <div class="flex space-x-1 text-sm text-gray-500">
                            <time :datetime="post.datetime">
                                {{ post.date }}
                            </time>
                            <span aria-hidden="true"> &middot; </span>
                            <span> {{ post.readingTime }} read </span>
                            </div>
                        </div>
                    </div> -->
                </div>
                </div>
            </div>
            </div>
        </div>

    </section>

</template>

<script>

const posts = [
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
    setup() {
        return {
            trendingProducts,
            posts,

        }
	},

    layout: 'LayoutWeb' // Define the layout for this page
}
</script>

<style>

</style>
