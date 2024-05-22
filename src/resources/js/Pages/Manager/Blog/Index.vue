
<template>
    <!-- eslint-disable -->
        <div class="w-full" >
            <header class="">
                <div class="flex justify-between max-w-7xl mx-auto py-6 px-10">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Novedades
                    </h2>
                    <a class="btn-blue" :href="route('posts.create')">
                        Crear Nota
                    </a>
                </div>
            </header>
    
            <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
    
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="showToast" class="rounded-md bg-green-50 p-4 mb-5  ">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ this.message }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" @click="showToast = false"
                                    class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                    <span class="sr-only">Dismiss</span>
                                    <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="content flex-grow flex flex-col">

                    <div class="content flex-grow flex flex-col">
                        <div v-for="post in posts.data" :key="post.id" 
                            class="rounded-md shadow bg-white mt-2 mb-4 w-4/5 mx-auto py-5 px-4 overflow-auto ">
                            <div class="text-gray-800 text-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="rounded-3xl h-32 w-32" :src="`/storage/${post.image}`" alt="">
                                    </div>    
                                    <div class="ml-8">
                                        <div class="mb-3 text-lg uppercase font-bold text-blue-800">{{ post.title }}</div>
                                        <span class="mt-3 font-bold bg-gray-100 px-2 py-1 text-center ">{{ post.post_category_id }}</span>
                                        <div class="mt-3">Creado: <span class="font-bold">{{ post.date_published }}</span> - Estado: <span class="font-bold">{{ post.post_status_id }}</span></div> 
                                    </div>
                                </div>
                                
                                <div class="mt-3 overflow-wrap-normal blog-content" v-html="post.content"></div>
                                <button @click="editPost(post.id)" class="mt-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Editar
                                </button>
                            </div>
                        </div>
                        <Pagination :links="posts.links" class="flex justify-end mx-5 mb-5" />
                    </div>
                </div>
            </div>
        </div>
    
    
    
    </template>
    <script>
    
    import { defineComponent } from 'vue'
    import { PencilIcon,
             TrashIcon,
             PlusCircleIcon,
             XMarkIcon,
             CheckCircleIcon,
             ChevronRightIcon,
             PhoneIcon,
             EnvelopeIcon          
            } from '@heroicons/vue/24/outline';
    import Toast from '@/Layouts/Components/Toast.vue';
    
    import {
             TransitionRoot, 
             Dialog, 
             DialogOverlay, 
             TransitionChild, 
             DialogTitle, 
            } from '@headlessui/vue'
    
    
    export default defineComponent({
        props: {
            toast: Object,
            posts: Object,
        },
        components: {
            TrashIcon,
            PencilIcon,
            PlusCircleIcon,
            Toast,
            XMarkIcon,
            CheckCircleIcon,
            ChevronRightIcon,
            PhoneIcon,
            EnvelopeIcon,
            TransitionRoot, 
            Dialog, 
            DialogOverlay, 
            TransitionChild, 
            DialogTitle,        
        },
        data() {
    
            return {
                open: false,
                clients: {},
                toastMessage: "",
                labelType: "info",
                message: "",
                showToast: false,
            }
        },
    
        methods: {
            editPost(postId) {
                // Redirige a la página de edición del post con el ID correspondiente
                this.$inertia.visit(route('posts.edit', { id: postId }));
            }, 

            clearMessage() {
                this.toastMessage = ""
            },
            

        },
    
        created() {

        },
        mounted()
        {
            if (this.toast) {
                if (this.toast["status"] == 200) {
                    this.labelType = "success";
                    this.toastMessage = this.toast["message"];
                } else {
                    this.labelType = "danger";
                    this.toastMessage = this.toast["message"];
                }
            }
        }
    
    })
    </script>
    
    <style>
        h1 {
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #4f46e5;
            line-height: 1.5rem;
            font-weight: 600;
        }
        h2 {
            font-size:1.25rem;
            letter-spacing: -0.025em;
            color: #111827;
            line-height: 1.5rem;
            font-weight: 800;
            margin-top:0.5rem;
        }
        p {
            font-size:1rem;
            color: #6b7280;
            line-height: 1.75rem;
            margin-top:2rem;
            text-align: justify;
        }

    </style>
    