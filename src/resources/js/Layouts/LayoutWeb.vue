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
	
							<!-- Links -->
							<TabGroup as="div" class="mt-2">
								<div class="border-b border-gray-200">
									<TabList class="-mb-px flex px-4 space-x-8">
										<Tab as="template" v-for="category in navigation.categories" :key="category.name" v-slot="{ selected }">
											<button :class="[selected ? 'text-indigo-600 border-indigo-600' : 'text-gray-900 border-transparent', 'flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium']">
												{{ category.name }}
											</button>
										</Tab>
									</TabList>
								</div>
								<TabPanels as="template">
									<TabPanel v-for="category in navigation.categories" :key="category.name" class="px-4 py-6 space-y-12">
										<div class="grid grid-cols-2 gap-x-4 gap-y-10">
											<div v-for="item in category.featured" :key="item.name" class="group relative">
												<div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
													<img :src="item.imageSrc" :alt="item.imageAlt" class="object-center object-cover" />
												</div>
												<a :href="item.href" class="mt-6 block text-sm font-medium text-gray-900">
													<span class="absolute z-10 inset-0" aria-hidden="true" />
													{{ item.name }}
												</a>
												<p aria-hidden="true" class="mt-1 text-sm text-gray-500">Shop now</p>
											</div>
										</div>
									</TabPanel>
								</TabPanels>
							</TabGroup>
	
							<div class="border-t border-gray-200 py-6 px-4 space-y-6">
								<div v-for="page in navigation.pages" :key="page.name" class="flow-root">
									<a :href="route(page.href)" class="-m-2 p-2 block font-medium text-gray-900">{{ page.name }}</a>
								</div>
							</div>
	
							<div class="border-t border-gray-200 py-6 px-4 space-y-6">
								<div class="flow-root">
									<a href="#" class="-m-2 p-2 block font-medium text-gray-900">Registrarse</a>
								</div>
								<div class="flow-root">
									<a href="#" class="-m-2 p-2 block font-medium text-gray-900">Ingresar</a>
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
						<div class="max-w-7xl mx-auto h-10 px-4 flex items-center justify-between sm:px-6 lg:px-8">
						<div>
								<!-- <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
										<path d="M17.525,9H14V7c0-1.032,0.084-1.682,1.563-1.682h1.868v-3.18C16.522,2.044,15.608,1.998,14.693,2 C11.98,2,10,3.657,10,6.699V9H7v4l3-0.001V22h4v-9.003l3.066-0.001L17.525,9z"></path>
								</svg> -->
								<!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" width="512" height="512">
										<g><path d="M12,2.162c3.204,0,3.584,0.012,4.849,0.07c1.308,0.06,2.655,0.358,3.608,1.311c0.962,0.962,1.251,2.296,1.311,3.608   c0.058,1.265,0.07,1.645,0.07,4.849c0,3.204-0.012,3.584-0.07,4.849c-0.059,1.301-0.364,2.661-1.311,3.608   c-0.962,0.962-2.295,1.251-3.608,1.311c-1.265,0.058-1.645,0.07-4.849,0.07s-3.584-0.012-4.849-0.07   c-1.291-0.059-2.669-0.371-3.608-1.311c-0.957-0.957-1.251-2.304-1.311-3.608c-0.058-1.265-0.07-1.645-0.07-4.849   c0-3.204,0.012-3.584,0.07-4.849c0.059-1.296,0.367-2.664,1.311-3.608c0.96-0.96,2.299-1.251,3.608-1.311   C8.416,2.174,8.796,2.162,12,2.162 M12,0C8.741,0,8.332,0.014,7.052,0.072C5.197,0.157,3.355,0.673,2.014,2.014   C0.668,3.36,0.157,5.198,0.072,7.052C0.014,8.332,0,8.741,0,12c0,3.259,0.014,3.668,0.072,4.948c0.085,1.853,0.603,3.7,1.942,5.038   c1.345,1.345,3.186,1.857,5.038,1.942C8.332,23.986,8.741,24,12,24c3.259,0,3.668-0.014,4.948-0.072   c1.854-0.085,3.698-0.602,5.038-1.942c1.347-1.347,1.857-3.184,1.942-5.038C23.986,15.668,24,15.259,24,12   c0-3.259-0.014-3.668-0.072-4.948c-0.085-1.855-0.602-3.698-1.942-5.038c-1.343-1.343-3.189-1.858-5.038-1.942   C15.668,0.014,15.259,0,12,0z"/><path d="M12,5.838c-3.403,0-6.162,2.759-6.162,6.162c0,3.403,2.759,6.162,6.162,6.162s6.162-2.759,6.162-6.162   C18.162,8.597,15.403,5.838,12,5.838z M12,16c-2.209,0-4-1.791-4-4s1.791-4,4-4s4,1.791,4,4S14.209,16,12,16z"/><circle cx="18.406" cy="5.594" r="1.44"/></g>
								</svg> -->

						</div>
							<div class="flex items-center space-x-6">
								<a href="#" class="text-sm font-medium text-white hover:text-gray-100">Ingresar</a>
								<a href="#" class="text-sm font-medium text-white hover:text-gray-100">Registrarse</a>
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
											<Popover v-for="category in navigation.categories" :key="category.name" class="flex" v-slot="{ open }">
												<div class="relative flex">
													<PopoverButton :class="[open ? 'text-indigo-600' : 'text-gray-50 hover:text-monsa-yellow', 'relative flex items-center justify-center transition-colors ease-out duration-200 text-sm font-bold uppercase']">
														{{ category.name }}
														<span :class="[open ? 'bg-indigo-600' : '', 'absolute z-20 -bottom-px inset-x-0 h-0.5 transition ease-out duration-200']" aria-hidden="true" />
													</PopoverButton>
												</div>
	
												<transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
													<PopoverPanel class="absolute z-10 top-full inset-x-0 bg-white text-sm text-gray-500">
														<!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
														<div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true" />
														<!-- Fake border when menu is open -->
														<div class="absolute inset-0 top-0 h-px max-w-7xl mx-auto px-8" aria-hidden="true">
															<div :class="[open ? 'bg-gray-200' : 'bg-transparent', 'w-full h-px transition-colors ease-out duration-200']" />
														</div>
	
														<div class="relative">
															<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
																<div class="grid grid-cols-4 gap-y-10 gap-x-8 py-16">
																	<div v-for="item in category.featured" :key="item.name" class="group relative">
																		<div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
																			<img :src="item.imageSrc" :alt="item.imageAlt" class="object-center object-cover" />
																		</div>
																		<a :href="item.href" class="mt-4 block font-medium text-gray-900">
																			<span class="absolute z-10 inset-0" aria-hidden="true" />
																			{{ item.name }}
																		</a>
																		<p aria-hidden="true" class="mt-1">Shop now</p>
																	</div>
																</div>
															</div>
														</div>
													</PopoverPanel>
												</transition>
											</Popover>
	
											<a v-for="page in navigation.pages" :key="page.name" :href="page.href" class="flex items-center text-sm font-bold text-gray-50 hover:text-monsa-yellow uppercase">{{ page.name }}</a>
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
									<!-- <a href="#" class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block"> Search </a> -->
	
									<div class="flex items-center lg:ml-8">
										<!-- Help -->
										<!-- <a href="#" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
											<span class="sr-only">Help</span>
											<QuestionMarkCircleIcon class="w-6 h-6" aria-hidden="true" />
										</a>
										<a href="#" class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">Help</a> -->
	
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
		// categories: [
		//   {
		//     name: 'Baterías',
		//     featured: [
		//       {
		//         name: 'New Arrivals',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg',
		//         imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
		//       },
		//       {
		//         name: 'Basic Tees',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg',
		//         imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
		//       },
		//       {
		//         name: 'Accessories',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-03.jpg',
		//         imageAlt: 'Model wearing minimalist watch with black wristband and white watch face.',
		//       },
		//       {
		//         name: 'Carry',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-04.jpg',
		//         imageAlt: 'Model opening tan leather long wallet with credit card pockets and cash pouch.',
		//       },
		//     ],
		//   },
		//   {
		//     name: 'Cascos',
		//     featured: [
		//       {
		//         name: 'New Arrivals',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-01.jpg',
		//         imageAlt: 'Hats and sweaters on wood shelves next to various colors of t-shirts on hangers.',
		//       },
		//       {
		//         name: 'Basic Tees',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-02.jpg',
		//         imageAlt: 'Model wearing light heather gray t-shirt.',
		//       },
		//       {
		//         name: 'Accessories',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-03.jpg',
		//         imageAlt:
		//           'Grey 6-panel baseball hat with black brim, black mountain graphic on front, and light heather gray body.',
		//       },
		//       {
		//         name: 'Carry',
		//         href: '#',
		//         imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-04.jpg',
		//         imageAlt: 'Model putting folded cash into slim card holder olive leather wallet with hand stitching.',
		//       },
		//     ],
		//   },
		// ],
		pages: [
			{ name: 'Baterias', href: 'tienda' },
			{ name: 'Cascos', href: 'tienda' },
			{ name: 'Tienda', href: 'tienda' },
			{ name: 'Nosotros', href: '/' },
			{ name: 'Novedades', href: '/' },
			{ name: 'Contacto', href: '/' },
		],
	}
	const collections = [
		{
			name: "Women's",
			href: '#',
			imageSrc: 'https://tailwindui.com/img/ecommerce-images/home-page-04-collection-01.jpg',
			imageAlt: 'Woman wearing a comfortable cotton t-shirt.',
		},
		{
			name: "Men's",
			href: '#',
			imageSrc: 'https://tailwindui.com/img/ecommerce-images/home-page-04-collection-02.jpg',
			imageAlt: 'Man wearing a comfortable and casual cotton t-shirt.',
		},
		{
			name: 'Desk Accessories',
			href: '#',
			imageSrc: 'https://tailwindui.com/img/ecommerce-images/home-page-04-collection-03.jpg',
			imageAlt: 'Person sitting at a wooden desk with paper note organizer, pencil and tablet.',
		},
	]
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
	const perks = [
		{
			name: 'Free returns',
			imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-returns-light.svg',
			description: 'Not what you expected? Place it back in the parcel and attach the pre-paid postage stamp.',
		},
		{
			name: 'Same day delivery',
			imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-calendar-light.svg',
			description:
				'We offer a delivery service that has never been done before. Checkout today and receive your products within hours.',
		},
		{
			name: 'All year discount',
			imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-gift-card-light.svg',
			description: 'Looking for a deal? You can use the code "ALLYEAR" at checkout and get money off all year round.',
		},
		{
			name: 'For the planet',
			imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-planet-light.svg',
			description: 'We’ve pledged 1% of sales to the preservation and restoration of the natural environment.',
		},
	]
	const footerNavigation = {
		products: [
			{ name: 'Bags', href: '#' },
			{ name: 'Tees', href: '#' },
			{ name: 'Objects', href: '#' },
			{ name: 'Home Goods', href: '#' },
			{ name: 'Accessories', href: '#' },
		],
		company: [
			{ name: 'Who we are', href: '#' },
			{ name: 'Sustainability', href: '#' },
			{ name: 'Press', href: '#' },
			{ name: 'Careers', href: '#' },
			{ name: 'Terms & Conditions', href: '#' },
			{ name: 'Privacy', href: '#' },
		],
		customerService: [
			{ name: 'Contact', href: '#' },
			{ name: 'Shipping', href: '#' },
			{ name: 'Returns', href: '#' },
			{ name: 'Warranty', href: '#' },
			{ name: 'Secure Payments', href: '#' },
			{ name: 'FAQ', href: '#' },
			{ name: 'Find a store', href: '#' },
		],
	}
	
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
				collections,
				trendingProducts,
				perks,
				footerNavigation,
				open,
			}
		},
	}
	</script>

<style>
	.font-exo{
		font-family: 'Exo 2', sans-serif;
	}

</style>