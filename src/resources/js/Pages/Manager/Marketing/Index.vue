<template>
    <!-- eslint-disable -->
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>

        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">

                    <div class="text-sm tracking-wide text-gray-700 font-bold mb-5">MENU</div>
                    <nav class="space-y-1">
                        <a v-for="(item,index) in subNavigation" :key="item.name" @click.prevent="selectItem(index)"
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
    import Popup from './Popup.vue';

    import { CogIcon,
             MapPinIcon,
             CubeIcon,
             TagIcon
              } from '@heroicons/vue/24/outline'


    const subNavigation = [
        { name: 'Popup',  icon: CogIcon, componentName: 'Popup' },
    ]

    export default {
        props: {
        },

        components: {
            Toast,
            Popup
        },

        setup() {
            return{
                subNavigation
            }
        },

        data() {
            return {
                toastMessage: "",
                labelType:    "info",
                selectedIndex: 0
            }
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
            return this.subNavigation[this.selectedIndex];
          }
        }
    }
    </script>