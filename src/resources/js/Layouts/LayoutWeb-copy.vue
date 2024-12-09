<template>
		<div class="bg-white font-exo">
			<!-- Mobile menu -->
			<TransitionRoot as="template" :show="open">
				<Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="open = false">
					<TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
						<DialogOverlay class="fixed inset-0 bg-black bg-opacity-25" />
					</TransitionChild>
	
					<TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
						<div class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto">
							<div class="px-4 pt-5 pb-2 flex">
								<button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400" @click="open = false">
									<span class="sr-only">Close menu</span>
									<XIcon class="h-6 w-6" aria-hidden="true" />
								</button>
							</div>
	
							<div class="border-t border-gray-200 py-6 px-4 space-y-6">
								<div class="flow-root" v-if="$page.props.show_module_store">
									<a :href="route('store')" class="-m-2 p-2 block font-medium text-gray-900">Tienda</a>
								</div>
								<div class="flow-root" v-if="!$page.props.show_module_store">
									<a :href="route('home')" class="-m-2 p-2 block font-medium text-gray-900">Inicio</a>
								</div>
								<div class="flow-root">
									<a :href="route('aboutus')" class="-m-2 p-2 block font-medium text-gray-900">Nosotros</a>
								</div>
								<div class="flow-root">
									<a :href="route('blog.list')" class="-m-2 p-2 block font-medium text-gray-900">Novedades</a>
								</div>
								<div class="flow-root">
									<a :href="route('contacto')" class="-m-2 p-2 block font-medium text-gray-900">Contacto</a>
								</div>
							</div>
	
							<div class="border-t border-gray-200 py-6 px-4 space-y-6">
								<!-- <div class="flow-root">
									<a :href="route('register')" class="-m-2 p-2 block font-medium text-gray-900">Registrarse</a>
								</div> -->
								<div class="flow-root" v-if="$page.props.show_module_store">
									<a :href="route('login')" class="-m-2 p-2 block font-medium text-gray-900">Ingresar</a>
								</div>
							</div>
								
						</div>
					</TransitionChild>
				</Dialog>
			</TransitionRoot>
			<!-- End Mobile menu -->
			
			<!-- Main Navigation -->
			<header class="relative">
				<nav aria-label="Top">
					<!-- Top navigation -->
					<!-- <div class="bg-monsa-blue">
						
						<div class="max-w-7xl mx-auto h-10 px-4 flex items-right justify-end sm:px-6 lg:px-8">
							<div class="flex items-center space-x-6" v-if="!this.$page.props.user">
								<a :href="route('login')" class="text-sm font-medium text-white hover:text-gray-100">Ingresar</a>
							</div>
							<div v-else class="flex items-center space-x-6">
								<a :href="route('dashboard')" class="text-sm font-medium text-white hover:text-gray-100">Administrar</a>
								<div @click="logout" class="text-sm font-medium text-white hover:text-gray-100">Salir</div>
							</div>
						</div>
						<div style=" background: url('/images/v.png');
											background-size: contain;
											opacity: 0.04;">
						</div>
					</div>  -->
					<div class="bg-monsa-blue relative">
						<!-- Fondo decorativo -->
						<div class="absolute inset-0" style="background: url('/images/v.png'); background-size: contain; opacity: 0.04;"></div>
						
						<!-- Contenido del menú -->
						<div class="relative z-10 mx-auto h-10 px-4 flex items-center justify-end sm:px-6 lg:px-8">
							<div class="flex items-center space-x-6 w-full" v-if="!this.$page.props.user">
								<div class="flex w-full items-center justify-end">
									<div class="w-3/6 text-white">🚚 Envios a todo el pais. </div>
									<a :href="route('login')" class="text-sm font-medium text-white hover:text-gray-100">Ingresar</a>
								</div>
							</div>
							<div v-else class="flex items-center space-x-6">
								<a :href="route('dashboard')" class="text-sm font-medium text-white hover:text-gray-100">Administrar</a>
								<div @click="logout" class="text-sm font-medium text-white hover:text-gray-100 cursor-pointer">Salir</div>
							</div>
						</div>
					</div>
					<!-- Secondary navigation -->
					<div class="bg-gray-900 bg-monsa-dark">
						<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
							<div class="h-16 flex items-center justify-between">
								<!-- Logo (lg+) -->
								<div class="hidden lg:flex-1 lg:flex lg:items-center">
									<a href="#">
										<img class="w-40" src="/images/logo-blanco.png" />
									</a>
								</div>
	
								<div class="hidden h-full lg:flex">
									<!-- Flyout menus -->
									<PopoverGroup class="px-4 bottom-0 inset-x-0">
										<div class="h-full flex justify-center space-x-8">
											<a v-if="$page.props.show_module_store"
											   :href="route('store')" 
											   class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-blue uppercase">Tienda</a>
											<a v-if="!$page.props.show_module_store"
											   :href="route('home')" 
											   class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-blue uppercase">Inicio</a>
											<a 
											   :href="route('aboutus')" 
											   class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-blue uppercase">Nosotros</a>
											<a 
											   :href="route('blog.list')" 
											   class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-blue uppercase">Novedades</a>
											<a 
												:href="route('contacto')" 
											   class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-blue uppercase">Contacto</a>
										</div>
									</PopoverGroup>
								</div>
								<!-- Mobile menu and search (lg-) -->
								<div class="flex-1 flex items-center lg:hidden">
									<button type="button" class="-ml-2 bg-white p-2 rounded-md text-gray-400" @click="open = true">
										<span class="sr-only">Open menu</span>
										<MenuIcon class="h-6 w-6" aria-hidden="true" />
									</button>
	
									<!-- Search -->
									<a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
										<span class="sr-only">Search</span>
										<SearchIcon class="w-6 h-6" aria-hidden="true" />
									</a>
								</div>
	
								<!-- Logo (lg-) -->
								<a href="#" class="lg:hidden">
									<img src="/images/monsa-srl-logo.png" alt="" class="h-8 w-auto" />
								</a>
	
								<div class="flex-1 flex items-center justify-end">
									<div class="flex items-center lg:ml-8">
										<!-- Cart -->
										<div class="ml-4 flow-root lg:ml-8">
											<a v-if="$page.props.show_module_store"
												:href="route('checkout')" class="group -m-2 p-2 flex items-center hover:text-monsa-yellow">
												<ShoppingBagIcon class="flex-shrink-0 h-6 w-6 text-gray-50 group-hover:text-gray-100" aria-hidden="true" />
												<span class="ml-2 text-sm font-medium text-gray-50 group-hover:text-gray-100">{{ totalItems }}</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</header>
			<!-- End Main Navigation -->
			
			<main>
				<!-- <pre v-if="$page.props.show_module_store">true - {{ $page.props.show_module_store }}</pre>
				<pre v-if="!$page.props.show_module_store">False - {{ $page.props.show_module_store }}</pre> -->
				<slot></slot>

			</main>
	
			<footer aria-labelledby="footer-heading" class="bg-monsa-blue">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 flex justify-center ">
					<div>
						<img class="h-10 w-auto" src="/images/MONSA_STORE_BLANCO_1.png" />
					</div>
					<div>
						<h3 class="text-sm font-bold text-white">Suscribite a nuestro newsletter</h3>

						<form class="flex">
							<input id="email-address" type="text" autocomplete="email" required="" class="appearance-none min-w-0 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
							<div class="ml-4 flex-shrink-0">
								<button type="submit" class="w-full bg-monsa-blue border border-transparent rounded-md shadow-sm py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Suscribirse</button>
							</div>
						</form>					
					</div>
				</div>
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div class="py-20">
						<div class="grid grid-cols-1 md:grid-cols-12 md:grid-flow-col md:gap-x-8 md:gap-y-16 md:auto-rows-min">
							<!-- Image section -->
							<div class="col-span-1 md:col-span-3">
								<img class="h-6 w-auto" src="/images/logo-negro.png" />
								<p class="mt-2">Monsa S.R.L.</p>
								<p>Av. Castañares 6140 - 1439</p>
								<p>Ciudad Autónoma de Buenos Aires, Argentina</p>
							</div>

							<div class="col-span-1 md:col-span-2">
								<h3 class="text-sm font-medium text-gray-900">Navegación</h3>
								<ul class="mt-6 space-y-4">
									<li v-if="$page.props.show_module_store"><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Tienda</a></li>
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Nosotros</a></li>
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Novedades</a></li>
									<li><a :href="route('contacto')" class="text-sm text-gray-500 hover:text-gray-900">Contacto</a></li>								
								</ul>
							</div>

							<div class="col-span-1 md:col-span-3">
								<h3 class="text-sm font-medium text-gray-900">Información Legal y Adicional</h3>
								<ul class="mt-6 space-y-4">
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Términos y Condiciones</a></li>
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Política de Privacidad</a></li>
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Política de Devoluciones y Reembolsos</a></li>
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Política de Envíos</a></li>
									<li><a href="#" class="text-sm text-gray-500 hover:text-gray-900">Preguntas Frecuentes</a></li>

								</ul>
							</div>
							<div class="col-span-1 md:col-span-3">
								<h3 class="text-sm font-bold text-gray-900">Suscribite a nuestro newsletter</h3>
								<p class="mt-6 text-sm text-gray-500">Recibí las últimas novedades y promociones que tenemos para vos.</p>
								<form class="flex">
									<input id="email-address" type="text" autocomplete="email" required="" class="appearance-none min-w-0 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
									<div class="ml-4 flex-shrink-0">
										<button type="submit" class="w-full bg-monsa-blue border border-transparent rounded-md shadow-sm py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Suscribirse</button>
									</div>
								</form>
								<!-- Redes sociales -->
								<div class="mt-6 flex space-x-4">
									<a href="#" class="text-gray-400 hover:text-gray-500">
										<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48"><path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z"></path><path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"></path></svg>
									</a>
									<a href="#" class="text-gray-400 hover:text-gray-500">
										<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48"><radialGradient id="yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1" cx="19.38" cy="42.035" r="44.899" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#fd5"></stop><stop offset=".328" stop-color="#ff543f"></stop><stop offset=".348" stop-color="#fc5245"></stop><stop offset=".504" stop-color="#e64771"></stop><stop offset=".643" stop-color="#d53e91"></stop><stop offset=".761" stop-color="#cc39a4"></stop><stop offset=".841" stop-color="#c837ab"></stop></radialGradient><path fill="url(#yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1)" d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"></path><radialGradient id="yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2" cx="11.786" cy="5.54" r="29.813" gradientTransform="matrix(1 0 0 .6663 0 1.849)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#4168c9"></stop><stop offset=".999" stop-color="#4168c9" stop-opacity="0"></stop></radialGradient><path fill="url(#yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2)" d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"></path><path fill="#fff" d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z"></path><circle cx="31.5" cy="16.5" r="1.5" fill="#fff"></circle><path fill="#fff" d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z"></path>
										</svg>
									</a>
								</div>
							</div>

						</div>
					</div>
	
					<div class="border-t border-gray-100 py-10 text-center">
						<p class="text-sm text-gray-500">&copy; 2024 Monsa SRL. Todos los derechos reservados. Diseño y Desarrollo por onMedia</p>
					</div>
				</div>

				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
					<div class="py-20">
						<div class="grid grid-cols-1 md:grid-cols-12 md:grid-flow-col md:gap-x-8 md:gap-y-16 md:auto-rows-min">
							<!-- Image section -->
							<div class="col-span-1 md:col-span-7">
								<img class="h-10 w-auto" src="/images/MONSA_STORE_BLANCO_1.png" />
								<div class="grid grid-cols-1 md:grid-cols-3 mt-8 ">
									<div class="col-span-3 md:col-span-1">
										<h3 class="text-sm font-bold">Navegación</h3>
										<ul class="mt-6 space-y-2">
											<li v-if="$page.props.show_module_store"><a href="#" class="text-sm hover:underline">Tienda</a></li>
											<li><a href="#" class="text-sm hover:underline">Nosotros</a></li>
											<li><a href="#" class="text-sm hover:underline">Novedades</a></li>
											<li><a :href="route('contacto')" class="text-sm">Contacto</a></li>								
										</ul>
									</div>

									<div class="col-span-3 md:col-span-2">
										<h3 class="text-sm font-bold">Información Legal y Adicional</h3>
										<ul class="mt-6 space-y-2">
											<li><a href="#" class="text-sm hover:underline">Términos y Condiciones</a></li>
											<li><a href="#" class="text-sm hover:underline">Política de Privacidad</a></li>
											<li><a href="#" class="text-sm hover:underline">Política de Devoluciones y Reembolsos</a></li>
											<li><a href="#" class="text-sm hover:underline">Política de Envíos</a></li>
											<li><a href="#" class="text-sm hover:underline">Preguntas Frecuentes</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="mt-2">Monsa S.R.L. - Av. Castañares 6140 - 1439 - Ciudad Autónoma de Buenos Aires, Argentina</div>
					</div>
	
					<div class="border-t border-gray-100 py-10 text-center">
						<p class="text-sm text-gray-500">&copy; 2024 Monsa SRL. Todos los derechos reservados. Diseño y Desarrollo por onMedia</p>
					</div>
				</div>
			</footer>
			<whatsappbtn links="https://whatwsapp"/>
		</div>	
	</template>
	
	<script>
	import { ref, computed } from 'vue'
	import {
		Dialog,
		DialogOverlay,
		Popover,
		PopoverButton,
		PopoverGroup,
		PopoverPanel,
		Tab,
		TabGroup,
		TabList,
		TabPanel,
		TabPanels,
		TransitionChild,
		TransitionRoot,
	} from '@headlessui/vue'
	
	import { MenuIcon,ShoppingBagIcon } from '@heroicons/vue/24/solid'
	import { useCartStore } from '../Stores/useCartStore'
	import Whatsappbtn from '../Layouts/Components/Whatsappbtn'
	const navigation = {
		pages: [
			{ name: 'Tienda', href: 'store' },
			{ name: 'Nosotros', href: 'aboutus' },
			{ name: 'Novedades', href: 'blog.list' },
			{ name: 'Contacto', href: 'home' },
		],
	}

	const trendingProducts = [
		{
			id: 1,
			name: 'CASCOS AGV K1 SOLID BLACK XL',
			color: 'Natural',
			price: '$ 123.456',
			href: '#',
			imageSrc: '/images/products/cascos/46692-1.jpg',
			imageAlt: 'CASCOS AGV K1 SOLID BLACK XL',
		},
		// More products...
	]


	
	export default {
		components: {
			Dialog,
			DialogOverlay,
			Popover,
			PopoverButton,
			PopoverGroup,
			PopoverPanel,
			Tab,
			TabGroup,
			TabList,
			TabPanel,
			TabPanels,
			TransitionChild,
			TransitionRoot,
			ShoppingBagIcon,
			Whatsappbtn,
			MenuIcon
		},
		setup() {
			const open = ref(false)
			const cart = useCartStore()

			// const totalItems = cart.totalItems()
			const totalItems = computed(() => cart.totalItems);


			return {
				navigation,
				trendingProducts,
				open,
				totalItems
			}
		},
		methods: {
			logout() {
                   this.$inertia.get(route('logout'));
            },
		},
	}
	</script>

<style>
	.font-exo{
		font-family: 'Exo 2', sans-serif;
	}

</style>