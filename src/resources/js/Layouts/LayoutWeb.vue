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
									<a :href="route('home')">
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
				
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
					<div class="pt-20 pb-5">
						<div class="grid grid-cols-1 md:grid-cols-12 md:grid-flow-col md:gap-x-8 md:gap-y-16 md:auto-rows-min">
							<!-- Image section -->
							<div class="col-span-1 md:col-span-7">
								<img class="h-10 w-auto" src="/images/MONSA_STORE_BLANCO_1.png" />
								<div class="grid grid-cols-1 md:grid-cols-3 mt-10 ">
									<div class="col-span-3 md:col-span-1">
										<h3 class="text-sm font-bold">Navegación</h3>
										<ul class="mt-6 space-y-2">
											<li v-if="$page.props.show_module_store">
												<a :href="route('store')" class="text-sm hover:underline">Tienda</a></li>
											<li><a :href="route('aboutus')" class="text-sm hover:underline">Nosotros</a></li>
											<li><a :href="route('blog.list')" class="text-sm hover:underline">Novedades</a></li>
											<li><a :href="route('contacto')" class="text-sm">Contacto</a></li>								
										</ul>
									</div>

									<div class="col-span-3 md:col-span-2">
										<h3 class="text-sm font-bold">Información Legal y Adicional</h3>
										<ul class="mt-6 space-y-2">
											<li><a :href="route('page', 'terminos-y-condiciones')" class="text-sm hover:underline">Términos y Condiciones</a></li>
											<li><a :href="route('page', 'politica-de-privacidad')" class="text-sm hover:underline">Política de Privacidad</a></li>
											<li><a :href="route('page', 'politica-de-devoluciones-y-reembolsos')" class="text-sm hover:underline">Política de Devoluciones y Reembolsos</a></li>
											<li><a :href="route('page', 'politica-de-envios')" class="text-sm hover:underline">Política de Envíos</a></li>
											<li><a :href="route('page', 'preguntas-frecuentes')" class="text-sm hover:underline">Preguntas Frecuentes</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-span-1 md:col-span-4">
								<div class="flex items-center justify-end  space-x-3" >
									<svg class="w-12 h-12" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7.90001C11.1891 7.90001 10.3964 8.14048 9.72218 8.59099C9.04794 9.0415 8.52243 9.68184 8.21211 10.431C7.90179 11.1802 7.8206 12.0046 7.9788 12.7999C8.13699 13.5952 8.52748 14.3258 9.10088 14.8992C9.67427 15.4725 10.4048 15.863 11.2001 16.0212C11.9955 16.1794 12.8198 16.0982 13.569 15.7879C14.3182 15.4776 14.9585 14.9521 15.409 14.2779C15.8596 13.6036 16.1 12.8109 16.1 12C16.1013 11.4612 15.9962 10.9275 15.7906 10.4295C15.585 9.93142 15.2831 9.47892 14.9021 9.09794C14.5211 8.71695 14.0686 8.415 13.5706 8.20942C13.0725 8.00385 12.5388 7.8987 12 7.90001ZM12 14.67C11.4719 14.67 10.9557 14.5134 10.5166 14.22C10.0776 13.9267 9.73534 13.5097 9.53326 13.0218C9.33117 12.5339 9.2783 11.9971 9.38132 11.4791C9.48434 10.9612 9.73863 10.4854 10.112 10.112C10.4854 9.73863 10.9612 9.48434 11.4791 9.38132C11.9971 9.2783 12.5339 9.33117 13.0218 9.53326C13.5097 9.73534 13.9267 10.0776 14.22 10.5166C14.5134 10.9557 14.67 11.4719 14.67 12C14.67 12.7081 14.3887 13.3873 13.888 13.888C13.3873 14.3887 12.7081 14.67 12 14.67ZM17.23 7.73001C17.23 7.9278 17.1714 8.12114 17.0615 8.28558C16.9516 8.45003 16.7954 8.57821 16.6127 8.65389C16.43 8.72958 16.2289 8.74938 16.0349 8.7108C15.8409 8.67221 15.6628 8.57697 15.5229 8.43712C15.3831 8.29727 15.2878 8.11909 15.2492 7.92511C15.2106 7.73112 15.2304 7.53006 15.3061 7.34733C15.3818 7.16461 15.51 7.00843 15.6744 6.89855C15.8389 6.78866 16.0322 6.73001 16.23 6.73001C16.4952 6.73001 16.7496 6.83537 16.9371 7.02291C17.1247 7.21044 17.23 7.4648 17.23 7.73001ZM19.94 8.73001C19.9691 7.48684 19.5054 6.28261 18.65 5.38001C17.7522 4.5137 16.5474 4.03897 15.3 4.06001C14 4.00001 10 4.00001 8.70001 4.06001C7.45722 4.0331 6.25379 4.49652 5.35001 5.35001C4.49465 6.25261 4.03093 7.45684 4.06001 8.70001C4.00001 10 4.00001 14 4.06001 15.3C4.03093 16.5432 4.49465 17.7474 5.35001 18.65C6.25379 19.5035 7.45722 19.9669 8.70001 19.94C10.02 20.02 13.98 20.02 15.3 19.94C16.5432 19.9691 17.7474 19.5054 18.65 18.65C19.5054 17.7474 19.9691 16.5432 19.94 15.3C20 14 20 10 19.94 8.70001V8.73001ZM18.24 16.73C18.1042 17.074 17.8993 17.3863 17.6378 17.6478C17.3763 17.9093 17.064 18.1142 16.72 18.25C15.1676 18.5639 13.5806 18.6715 12 18.57C10.4228 18.6716 8.83902 18.564 7.29001 18.25C6.94608 18.1142 6.63369 17.9093 6.37223 17.6478C6.11076 17.3863 5.90579 17.074 5.77001 16.73C5.35001 15.67 5.44001 13.17 5.44001 12.01C5.44001 10.85 5.35001 8.34001 5.77001 7.29001C5.90196 6.94268 6.10547 6.62698 6.36733 6.36339C6.62919 6.09981 6.94355 5.89423 7.29001 5.76001C8.83902 5.44599 10.4228 5.33839 12 5.44001C13.5806 5.33856 15.1676 5.44616 16.72 5.76001C17.064 5.89579 17.3763 6.10076 17.6378 6.36223C17.8993 6.62369 18.1042 6.93608 18.24 7.28001C18.66 8.34001 18.56 10.84 18.56 12C18.56 13.16 18.66 15.67 18.24 16.72V16.73Z" fill="#ffffff"></path> </g></svg>
									<svg class="w-12 h-12" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 12.05C19.9813 10.5255 19.5273 9.03809 18.6915 7.76295C17.8557 6.48781 16.673 5.47804 15.2826 4.85257C13.8921 4.2271 12.3519 4.01198 10.8433 4.23253C9.33473 4.45309 7.92057 5.10013 6.7674 6.09748C5.61422 7.09482 4.77005 8.40092 4.3343 9.86195C3.89856 11.323 3.88938 12.8781 4.30786 14.3442C4.72634 15.8103 5.55504 17.1262 6.69637 18.1371C7.83769 19.148 9.24412 19.8117 10.75 20.05V14.38H8.75001V12.05H10.75V10.28C10.7037 9.86846 10.7483 9.45175 10.8807 9.05931C11.0131 8.66687 11.23 8.30827 11.5161 8.00882C11.8022 7.70936 12.1505 7.47635 12.5365 7.32624C12.9225 7.17612 13.3368 7.11255 13.75 7.14003C14.3498 7.14824 14.9482 7.20173 15.54 7.30003V9.30003H14.54C14.3676 9.27828 14.1924 9.29556 14.0276 9.35059C13.8627 9.40562 13.7123 9.49699 13.5875 9.61795C13.4627 9.73891 13.3667 9.88637 13.3066 10.0494C13.2464 10.2125 13.2237 10.387 13.24 10.56V12.07H15.46L15.1 14.4H13.25V20C15.1399 19.7011 16.8601 18.7347 18.0985 17.2761C19.3369 15.8175 20.0115 13.9634 20 12.05Z" fill="#ffffff"></path> </g></svg>
								</div>
								<div class="mt-8">
									<h3 class="text-sm font-bold text-white">Suscribite a nuestro newsletter</h3>
									<p class="mt-6 text-sm text-white">Recibí las últimas novedades y promociones que tenemos para vos.</p>
									<div class="flex" v-if="!alertMessage">
										<input id="email-address" type="text" autocomplete="email" v-model="email" class="appearance-none border-white bg-monsa-blue min-w-0 w-full border border-bottom-1 rounded-md shadow-sm py-2 px-4 text-base text-white " />
										<div class="ml-4 flex-shrink-0">
											<button @click="subscribe" class="w-full bg-white border border-transparent rounded-md shadow-sm py-2 px-4 flex items-center justify-center text-base font-medium text-monsa-blue hover:bg-monsa-blue hover:text-white hover:border-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Suscribirse</button>
										</div>
									</div>	
									<Alert :message="alertMessage" :type="alertType" @clear="clearMessage" />
								</div>
								<div class="mt-8 w-16"> 
									<a href="http://qr.afip.gob.ar/?qr=TCwMdwjOQ0Ro_jSB62EtYw,," target="_F960AFIPInfo"><img src="http://www.afip.gob.ar/images/f960/DATAWEB.jpg" border="0"></a>
								</div>
							</div>
						</div>

						<div class="mt-6 text-sm">Monsa S.R.L. - Av. Castañares 6140 - 1439 - Ciudad Autónoma de Buenos Aires, Argentina</div>
					</div>
	
					<div class="border-t border-gray-100 pt-8 pb-5 text-center">
						<p class="text-sm text-white">&copy; 2024 Monsa SRL. Todos los derechos reservados. <a href="https://onmedia.com.ar" target="_blank" class="text-white hover:text-gray-100 hover:underline">Diseño y Desarrollo por onMedia</a></p>
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
	//  import { MenuIcon, QuestionMarkCircleIcon, SearchIcon, ShoppingBagIcon, XIcon } from '@heroicons/vue/24/solid'
	import { ShoppingBagIcon } from '@heroicons/vue/24/solid'
	import { useCartStore } from '../Stores/useCartStore'
	import Whatsappbtn from '../Layouts/Components/Whatsappbtn'
	import Alert from '../Layouts/Components/Alert'

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
			Alert

		},
		data() {
			return {
			alertMessage: '',
			email: '',
			alertType: 'success' // Default type
			};
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
				totalItems,
			}
		},
		methods: {
			logout() {
                   this.$inertia.get(route('logout'));
            },
			clearMessage() {
				this.alertMessage = ''; // Limpia el mensaje cuando se oculta el alert
			},
			async subscribe(){

				if(!this.email){
					this.alertMessage = 'El email es requerido';
					this.alertType = 'warning'; // Set type to warning
					return;
				}
				try {
					let url = route('suscribe');
					const response = await axios.post(url, {
						email: this.email
					});
					console.log(response);
					if (response.status === 200 && response.data.message) {
						this.alertMessage = response.data.message;
						this.alertType = 'success';
					}
				} catch (error) {
					if (error.response && error.response.status === 400) {
						this.alertMessage = error.response.data.message;
						this.alertType = 'warning'; // Set type to warning
					} else {
						alert('An unexpected error occurred.');
					}
				}
			}
		},
	}
	</script>

<style>
	.font-exo{
		font-family: 'Exo 2', sans-serif;
	}

</style>