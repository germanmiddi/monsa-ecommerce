<template>
    <!--eslint-disable  -->
    <div class="flex-grow min-h-full mb-12 relative">
        <!-- Fondo decorativo -->
        <div class="absolute inset-0 bg-gradient-to-b from-monsa-blue to-blue-900 w-full z-0 h-96   overflow-hidden">
            <div class="section px-6 py-20 md:py-60 w-full" style="background:url('/images/v.png'); opacity:0.05">
            </div>
        </div>
        <!-- Contenido del post -->
        <div class="relative z-10 pt-24">
            <div class="flex justify-center">
                <div class="text-4xl text-white tracking-tight font-extrabold uppercase">{{ page.title }}</div>
            </div>
        </div>
    </div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="relative bg-white pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
        <div class="relative max-w-7xl mx-auto">
            <div v-html="page.content"></div>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        page: {
            type: Object,
            required: true
        }
    },
    methods: {

    }
}

</script>

<style>

h1{
    @apply text-4xl font-bold;
}
h2{
    @apply text-2xl font-bold;
}
h3{
    @apply text-lg font-bold;
}
h4{
    @apply text-base font-bold;
}
h5{
    @apply text-sm font-bold;
}
h6{
    @apply text-xs font-bold;
}
p{
    @apply text-base text-gray-700;   
}

</style>