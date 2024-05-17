<template>
  <!-- eslint-disable -->
    <header class="">
      <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
              <ChevronLeftIcon class="w-5 mr-2 rounded-full hover:bg-white" @click="goBack" /> Contenido
          </h2>
      </div>
  </header>

    <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
  
    <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
          <nav class="space-y-1">
            <a v-for="(item,index) in asideItems" :key="item.name" @click.prevent="selectItem(index)"
              :class="[selectedIndex === index ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium cursor-pointer']">
              <component :is="item.icon" :class="[selectedIndex === index ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
              <span class="truncate">{{ item.name }}</span>
            </a>
          </nav>
        </aside>
    
        <!-- Payment details -->
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
          <component @message="messageToast" :is="selectedItem.componentName" :data="selectedItem.componentData" />
        </div>
      </div>
    </main>
  
  </template>
  
  
  <script>
  import Toast from '@/Layouts/Components/Toast.vue'
  import HomeSlider from './HomeSlider/Index.vue'
  import HomeBrands from './HomeBrands/Index.vue'
  import HomeBanner from './HomeBanner/Index.vue'  
  import Aboutus from './Aboutus/Index.vue'

 
  import { CogIcon,
           MapPinIcon,
           CubeIcon
        } from '@heroicons/vue/24/outline'  
  
  
  const asideItems = [
      { name: 'Slider', icon: CubeIcon, componentName: 'HomeSlider' },
      { name: 'Marcas', icon: CubeIcon, componentName: 'HomeBrands' },
      { name: 'Banner Promoción', icon: CubeIcon, componentName: 'HomeBanner' },
      { name: 'Page - Nosotros', icon: CubeIcon, componentName: 'Aboutus' },

    ]
  
  export default {
    props: {
    },
  
    components: {
      Toast,
      HomeSlider,
      HomeBrands,
      HomeBanner,
      Aboutus
    },
  
    setup() {
      return{
        asideItems
      }
    },
  
    data() {
  
      return {
        toastMessage: "",
        labelType:    "info",
        selectedIndex: 0
      
      }
    },
    watch: {
  
    },
  
    created() {
  
    },
      methods: {
        clearMessage() {
          this.toastMessage = "";
        },
        selectItem(index) {
          this.selectedIndex = index;
        },
        messageToast(data){
          this.labelType = data.labelType;
          this.toastMessage = data.message;
        }
      },
      computed: {
        selectedItem() {
          return this.asideItems[this.selectedIndex];
        }
      }
  }
  </script>