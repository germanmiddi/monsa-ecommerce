<template>
    <div class="min-h-screen flex flex-col sm:justify-center sm:-mt-16  items-center pt-6 sm:pt-0 bg-gray-50">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center font-bold text-lg py-4  text-monsa-blue font-neue font-heavy uppercase">
                Acceso a la tienda online
            </div>
           
            <slot />
            
            <div class="mt-6 border-t border-gray-200 pt-4">

                <a href="https://www.monsa-srl.com.ar/pedidosweb" class="text-sm text-gray-600 hover:underline">Si ud es un cliente <span class="font-bold text-monsa-blue">mayorista</span>, puede acceder haciendo click <span class="font-bold text-monsa-blue">aquí.</span></a>
            </div>
        </div>
        
    </div>
</template>
