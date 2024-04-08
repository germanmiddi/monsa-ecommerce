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
								<div v-for="page in navigation.pages" :key="page.name" class="flow-root">
									<a :href="route(page.href)" class="-m-2 p-2 block font-medium text-gray-900">{{ page.name }}</a>
								</div>
							</div>
	
							<div class="border-t border-gray-200 py-6 px-4 space-y-6">
								<div class="flow-root">
									<a :href="route('register')" class="-m-2 p-2 block font-medium text-gray-900">Registrarse</a>
								</div>
								<div class="flow-root">
									<a :href="route('login')" class="-m-2 p-2 block font-medium text-gray-900">Ingresar</a>
								</div>
							</div>
								
						</div>
					</TransitionChild>
				</Dialog>
			</TransitionRoot>
	
			<header class="relative">
				<nav aria-label="Top">
					<!-- Top navigation -->
					<div class="bg-gray-800">
						<div class="max-w-7xl mx-auto h-10 px-4 flex items-right justify-end sm:px-6 lg:px-8">
							<div class="flex items-center space-x-6" v-if="!this.$page.props.user">
								<a :href="route('login')" class="text-sm font-medium text-white hover:text-gray-100">Ingresar</a>
								<a :href="route('register')" class="text-sm font-medium text-white hover:text-gray-100">Registrarse</a>
							</div>
							<div v-else class="flex items-center space-x-6">
								<a :href="route('dashboard')" class="text-sm font-medium text-white hover:text-gray-100">Administrar</a>
								<div @click="logout" class="text-sm font-medium text-white hover:text-gray-100">Salir</div>
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
										<img class="w-40" src="/images/monsa-srl-logo.png" />
									</a>
								</div>
	
								<div class="hidden h-full lg:flex">
									<!-- Flyout menus -->
									<PopoverGroup class="px-4 bottom-0 inset-x-0">
										<div class="h-full flex justify-center space-x-8">
											<a v-for="page in navigation.pages" :key="page.name" 
											   :href="route(page.href)" 
											   class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-yellow uppercase">{{ page.name }}</a>
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
											<a href="#" class="group -m-2 p-2 flex items-center">
												<ShoppingBagIcon class="flex-shrink-0 h-6 w-6 text-gray-50 group-hover:text-gray-100" aria-hidden="true" />
												<span class="ml-2 text-sm font-medium text-gray-50 group-hover:text-gray-100">0</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</header>
	
			<main>
				<slot></slot>

			</main>
	
			<footer aria-labelledby="footer-heading" class="bg-gray-50">
				<h2 id="footer-heading" class="sr-only">Footer</h2>
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div class="border-t border-gray-200 py-20">
						<div class="grid grid-cols-1 md:grid-cols-12 md:grid-flow-col md:gap-x-8 md:gap-y-16 md:auto-rows-min">
							<!-- Image section -->
							<div class="col-span-1 md:col-span-2 lg:row-start-1 lg:col-start-1">
								<!-- <img src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" /> -->
								<img class="h-8 w-auto" src="/images/monsa-srl-logo.png" />
							</div>
	
							<!-- Sitemap sections -->
							
	
							<!-- Newsletter section -->
							<div class="mt-12 md:mt-0 md:row-start-2 md:col-start-3 md:col-span-8 lg:row-start-1 lg:col-start-9 lg:col-span-4">
								<h3 class="text-sm font-medium text-gray-900">Suscribite a nuestro newsletter</h3>
								<p class="mt-6 text-sm text-gray-500">The latest deals and savings, sent to your inbox weekly.</p>
								<form class="mt-2 flex sm:max-w-md">
									<label for="email-address" class="sr-only">Email</label>
									<input id="email-address" type="text" autocomplete="email" required="" class="appearance-none min-w-0 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
									<div class="ml-4 flex-shrink-0">
										<button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign up</button>
									</div>
								</form>
							</div>
						</div>
					</div>
	
					<div class="border-t border-gray-100 py-10 text-center">
						<p class="text-sm text-gray-500">&copy; 2024 Monsa SRL. Todos los derechos reservados. Diseño y Desarrollo por onMedia</p>
					</div>
				</div>
			</footer>
		</div>
	</template>
	
	<script>
	import { ref } from 'vue'
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
			// MenuIcon,
			// QuestionMarkCircleIcon,
			// SearchIcon,
			ShoppingBagIcon,
			// XIcon,
		},
		setup() {
			const open = ref(false)
	
			return {
				navigation,
				trendingProducts,
				open,
			}
		},
		methods: {
			logout() {
                   this.$inertia.post(route('logout'));
            },
		},
	}
	</script>

<style>
	.font-exo{
		font-family: 'Exo 2', sans-serif;
	}

</style>