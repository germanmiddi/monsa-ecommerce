<template>
  <div class="bg-white">
    <div>
      <!-- Mobile filter dialog -->
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="mobileFiltersOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
            enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
            leave-to="opacity-0">
            <DialogOverlay class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
            enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform"
            leave-from="translate-x-0" leave-to="translate-x-full">
            <div
              class="ml-auto relative max-w-xs w-full h-full bg-white shadow-xl py-4 pb-12 flex flex-col overflow-y-auto">
              <div class="px-4 flex items-center justify-between">
                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                <button type="button"
                  class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-gray-400"
                  @click="mobileFiltersOpen = false">
                  <span class="sr-only">Close menu</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>

              <!-- Filters -->
              <form class="mt-4 border-t border-gray-200">
                <!-- <h3 class="sr-only">Categories</h3>
                  <ul role="list" class="font-medium text-gray-900 px-2 py-3">
                    <li v-for="category in subCategories" :key="category.name">
                      <a :href="category.href" class="block px-2 py-3">
                        {{ category.name }}
                      </a>
                    </li>
                  </ul> -->

                <Disclosure as="div" v-for="section in filters" :key="section.id"
                  class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                  <h3 class="-mx-2 -my-3 flow-root">
                    <DisclosureButton
                      class="px-2 py-3 bg-white w-full flex items-center justify-between text-gray-400 hover:text-gray-500">
                      <span class="font-medium text-gray-900">
                        {{ section.name }}
                      </span>
                      <span class="ml-6 flex items-center">
                        <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                        <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                      </span>
                    </DisclosureButton>
                  </h3>
                  <DisclosurePanel class="pt-6">
                    <div class="space-y-6">
                      <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                        <input :id="`filter-mobile-${section.id}-${optionIdx}`" :name="`${section.id}[]`"
                          :value="option.value" type="checkbox" :checked="option.checked"
                          class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />
                        <label :for="`filter-mobile-${section.id}-${optionIdx}`"
                          class="ml-3 min-w-0 flex-1 text-gray-500">
                          {{ option.label }}
                        </label>
                      </div>
                    </div>
                  </DisclosurePanel>
                </Disclosure>
              </form>
            </div>
          </TransitionChild>
        </Dialog>
      </TransitionRoot>

      <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative z-10 flex items-baseline justify-between pt-12 pb-6 border-b border-gray-200">
          <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Tienda</h1>
          <div class="w-1/2">
            <input type="text" v-model="searchTerm" class="border-2 border-gray-200 rounded-md p-2 w-full"
              placeholder="Buscar producto, marcas, y más ..." />
          </div>
          <div class="flex items-center">
            <div class="mr-4">
              <select v-model="sortOrder"
                      class="border border-gray-300 rounded-md px-3 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Ordenar por precio</option>
                <option value="price_asc">Precio: Menor a Mayor</option>
                <option value="price_desc">Precio: Mayor a Menor</option>
              </select>
            </div>
          </div>
        </div>

        <section aria-labelledby="products-heading" class="pt-6 pb-24">
          <h2 id="products-heading" class="sr-only">Productos</h2>

          <div class="grid grid-cols-1 lg:grid-cols-6 gap-x-8 gap-y-10">
            <!-- Filters -->
            <form class="hidden lg:block py-4">
                <h3 class="text-sm font-medium text-gray-900 mb-4">Categorías</h3>
                <div class="space-y-4 pb-6 border-b border-gray-200">
                    <div v-for="category in categories" :key="category.id" class="flex items-center">
                        <input :id="`filter-category-${category.id}`" :name="`category-${category.name}`" :value="category.name"
                            type="checkbox" :checked="selectedCategories.includes(category.name)"
                            @change="handleCategoryChange(category.name, $event.target.checked)"
                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />
                        <label :for="`filter-category-${category.id}`" class="ml-3 text-sm text-gray-600">
                            {{ category.name }}
                        </label>
                    </div>
                </div>

              <Disclosure as="div" class="border-b border-gray-200 py-6" v-slot="{ open }">
                <h3 class="-my-3 flow-root">
                  <DisclosureButton
                    class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">
                      Marcas
                    </span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="option in brands" :key="option.id" class="flex items-center">
                      <input :id="`filter-brand-${option.id}`" :name="`brand-${option.nombre}`" :value="option.nombre"
                        type="checkbox" :checked="selectedBrands.includes(option.nombre)"
                        @change="handleBrandChange(option.nombre, $event.target.checked)"
                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />

                      <label :for="`filter-brand-${option.id}`" class="ml-3 text-sm text-gray-600">
                        {{ option.nombre }}
                      </label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>

              <Disclosure as="div" class="border-b border-gray-200 py-6" v-slot="{ open }">
                <h3 class="-my-3 flow-root">
                  <DisclosureButton
                    class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">
                      Familia
                    </span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="option in families" :key="option.id" class="flex items-center">
                      <input :id="`filter-family-${option.id}`" :name="`family-${option.nombre}`" :value="option.nombre"
                        type="checkbox" :checked="selectedFamilies.includes(option.nombre)"
                        @change="handleFamilyChange(option.nombre, $event.target.checked)"
                        class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />
                      <label :for="`filter-family-${option.id}`" class="ml-3 text-sm text-gray-600">
                        {{ option.nombre }}
                      </label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>
            </form>

            <!-- Product grid -->
            <div class="lg:col-span-5">
              <!-- Active Filters -->
              <div v-if="hasActiveFilters" class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between mb-3">
                  <h3 class="text-sm font-medium text-gray-900">Filtros activos:</h3>
                  <button @click="clearAllFilters"
                          class="text-sm text-red-600 hover:text-red-800 underline">
                    Limpiar todos
                  </button>
                </div>
                <div class="flex flex-wrap gap-2">
                  <!-- Search filter -->
                  <span v-if="searchTerm"
                        class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                    Búsqueda: "{{ searchTerm }}"
                    <button @click="clearSearch" class="ml-2 hover:text-blue-600">
                      <XMarkIcon class="h-4 w-4" />
                    </button>
                  </span>

                  <!-- Category filters -->
                  <span v-for="category in selectedCategories" :key="`cat-${category}`"
                        class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-800">
                    Categoría: {{ category }}
                    <button @click="removeCategoryFilter(category)" class="ml-2 hover:text-purple-600">
                      <XMarkIcon class="h-4 w-4" />
                    </button>
                  </span>

                  <!-- Brand filters -->
                  <span v-for="brand in selectedBrands" :key="`brand-${brand}`"
                        class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                    Marca: {{ brand }}
                    <button @click="removeBrandFilter(brand)" class="ml-2 hover:text-green-600">
                      <XMarkIcon class="h-4 w-4" />
                    </button>
                  </span>

                  <!-- Family filters -->
                  <span v-for="family in selectedFamilies" :key="`family-${family}`"
                        class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800">
                    Familia: {{ family }}
                    <button @click="removeFamilyFilter(family)" class="ml-2 hover:text-yellow-600">
                      <XMarkIcon class="h-4 w-4" />
                    </button>
                  </span>

                  <!-- Sort filter -->
                  <span v-if="sortOrder"
                        class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-800">
                    {{ sortOrder === 'price_asc' ? 'Precio: Menor a Mayor' : 'Precio: Mayor a Menor' }}
                    <button @click="sortOrder = ''" class="ml-2 hover:text-indigo-600">
                      <XMarkIcon class="h-4 w-4" />
                    </button>
                  </span>
                </div>
              </div>

              <!-- Replace with your content -->
              <Products :products="visibleProducts" />
              <!-- <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 lg:h-full" /> -->
              <!-- /End replace -->

              <!-- <button class="btn-monsa-xl mx-auto mt-4"
                      v-if="visibleCount < filteredProducts.length"
                      @click="loadMore">Ver más</button> -->

              <button @click="loadMore" v-if="visibleCount < filteredProducts.length"
                       class="flex items-center justify-center mt-20
                              uppercase bg-[#232323] rounded text-white font-bold border border-transparent py-3 px-8 mx-auto w-[250px]
                              hover:border-[#232323] hover:bg-white hover:text-[#232323]">Ver más</button>



            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>

<script>


import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import {
  Dialog,
  DialogOverlay,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import {
  ChevronDownIcon,
  FunnelIcon,
  MinusIcon,
  PlusIcon,
  Squares2X2Icon
} from '@heroicons/vue/24/solid';
import Products from './Products.vue';

const sortOptions = [
  { name: 'Most Popular', href: '#', current: true },
  { name: 'Best Rating', href: '#', current: false },
  { name: 'Newest', href: '#', current: false },
  { name: 'Price: Low to High', href: '#', current: false },
  { name: 'Price: High to Low', href: '#', current: false },
]
const subCategories = [
  { name: 'Baterias', href: '#' },
  { name: 'Camaras', href: '#' },
  { name: 'Cascos', href: '#' },
  { name: 'Cubierta Moto', href: '#' },
  { name: 'Indumentaria de Lluvia', href: '#' },
]
const filters = [
  {
    id: 'color',
    name: 'Marca',
    options: [
      { value: 'white', label: 'White', checked: false },
      { value: 'beige', label: 'Beige', checked: false },
      { value: 'blue', label: 'Blue', checked: true },
      { value: 'brown', label: 'Brown', checked: false },
      { value: 'green', label: 'Green', checked: false },
      { value: 'purple', label: 'Purple', checked: false },
    ],
  },
  {
    id: 'category',
    name: 'Familia',
    options: [
      { value: 'new-arrivals', label: 'New Arrivals', checked: false },
      { value: 'sale', label: 'Sale', checked: false },
      { value: 'travel', label: 'Travel', checked: true },
      { value: 'organization', label: 'Organization', checked: false },
      { value: 'accessories', label: 'Accessories', checked: false },
    ],
  },
  //   {
  //     id: 'size',
  //     name: 'Size',
  //     options: [
  //       { value: '2l', label: '2L', checked: false },
  //       { value: '6l', label: '6L', checked: false },
  //       { value: '12l', label: '12L', checked: false },
  //       { value: '18l', label: '18L', checked: false },
  //       { value: '20l', label: '20L', checked: false },
  //       { value: '40l', label: '40L', checked: true },
  //     ],
  //   },
]

export default {
  props: {
    families: Array,
    products: Array,
    brands: Array,
    categories: Array,
  },

  components: {
    Products,
    Dialog,
    DialogOverlay,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    ChevronDownIcon,
    FunnelIcon,
    MinusIcon,
    PlusIcon,
    Squares2X2Icon,
    XMarkIcon,
  },

  setup(props) {
    const mobileFiltersOpen = ref(false);
    const searchTerm = ref('');
    const selectedBrands = ref([]);
    const selectedFamilies = ref([]);
    const selectedCategories = ref([]);
    const sortOrder = ref('');
    const productsPerPage = 20;
    const visibleCount = ref(productsPerPage);
    const { products } = props;

    const filteredProducts = computed(() => {
      let filtered = products.filter(product => {
        const matchesBrand = selectedBrands.value.length === 0 || selectedBrands.value.includes(product.brand.nombre);
        const matchesFamily = selectedFamilies.value.length === 0 || selectedFamilies.value.includes(product.family.nombre);
        const matchesCategory = selectedCategories.value.length === 0 ||
          (product.categories && product.categories.some(category => selectedCategories.value.includes(category.name)));
        // const matchesSearch = product.search.toLowerCase().includes(searchTerm.value.toLowerCase());
        const matchesSearch = product.search && typeof product.search === 'string' ? product.search.toLowerCase().includes(searchTerm.value.toLowerCase()) : false;

        return matchesBrand && matchesFamily && matchesCategory && matchesSearch;
      });

      // Apply sorting
      if (sortOrder.value === 'price_asc') {
        filtered.sort((a, b) => parseFloat(a.precio) - parseFloat(b.precio));
      } else if (sortOrder.value === 'price_desc') {
        filtered.sort((a, b) => parseFloat(b.precio) - parseFloat(a.precio));
      }

      return filtered;
    });

    const visibleProducts = computed(() => {
      return filteredProducts.value.slice(0, visibleCount.value);
    });

    const loadMore = () => {
      visibleCount.value += productsPerPage;
    };


    const handleBrandChange = (brandName, isChecked) => {
      if (isChecked) {
        selectedBrands.value.push(brandName);
      } else {
        selectedBrands.value = selectedBrands.value.filter(b => b !== brandName);
      }
      visibleCount.value = productsPerPage; // Reset pagination
    };

    const handleFamilyChange = (familyName, isChecked) => {
      if (isChecked) {
        selectedFamilies.value.push(familyName);
      } else {
        selectedFamilies.value = selectedFamilies.value.filter(f => f !== familyName);
      }
      visibleCount.value = productsPerPage; // Reset pagination
    };

    const handleCategoryChange = (categoryName, isChecked) => {
      if (isChecked) {
        selectedCategories.value.push(categoryName);
      } else {
        selectedCategories.value = selectedCategories.value.filter(c => c !== categoryName);
      }
      visibleCount.value = productsPerPage; // Reset pagination
    };

    const hasActiveFilters = computed(() => {
      return searchTerm.value || selectedCategories.value.length > 0 || selectedBrands.value.length > 0 || selectedFamilies.value.length > 0 || sortOrder.value;
    });

    const clearAllFilters = () => {
      searchTerm.value = '';
      selectedCategories.value = [];
      selectedBrands.value = [];
      selectedFamilies.value = [];
      sortOrder.value = '';
      visibleCount.value = productsPerPage; // Reset pagination
    };

    const clearSearch = () => {
      searchTerm.value = '';
    };

    const removeCategoryFilter = (category) => {
      selectedCategories.value = selectedCategories.value.filter(c => c !== category);
      visibleCount.value = productsPerPage; // Reset pagination
    };

    const removeBrandFilter = (brand) => {
      selectedBrands.value = selectedBrands.value.filter(b => b !== brand);
      visibleCount.value = productsPerPage; // Reset pagination
    };

    const removeFamilyFilter = (family) => {
      selectedFamilies.value = selectedFamilies.value.filter(f => f !== family);
      visibleCount.value = productsPerPage; // Reset pagination
    };

    // Watch searchTerm to reset pagination when searching
    watch(searchTerm, () => {
      visibleCount.value = productsPerPage;
    });

    // Watch sortOrder to reset pagination when sorting
    watch(sortOrder, () => {
      visibleCount.value = productsPerPage;
    });

    return {
      mobileFiltersOpen,
      visibleProducts,
      sortOptions,
      subCategories,
      filters,
      filteredProducts,
      handleBrandChange,
      handleFamilyChange,
      handleCategoryChange,
      selectedBrands,
      selectedFamilies,
      selectedCategories,
      searchTerm,
      sortOrder,
      loadMore,
      visibleCount,
      hasActiveFilters,
      clearAllFilters,
      clearSearch,
      removeCategoryFilter,
      removeBrandFilter,
      removeFamilyFilter

      // products,
    }
  },

  data() {

  },

  methods: {

  },

}

</script>
