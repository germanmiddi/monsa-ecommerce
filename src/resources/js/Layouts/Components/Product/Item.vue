<template>
    <div class="group relative bg-white  rounded-lg flex flex-col overflow-hidden">
        <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
            <img :src="buildImg(product.imagen)" alt="Lorem"
                class="w-full h-full object-center object-cover group-hover:opacity-75" />
        </div>
        <div v-show="product.promo_text"
            class="absolute mt-8 mx-8 ml-1 xl:ml-2 bg-monsa-blue text-white rounded-sm  p-2 font-semibold bg-opacity-90 text-sm">
            <span class="">{{ product.promo_text ?? '-' }}</span>
        </div>
        <div class="flex-1 p-4 space-y-2 flex flex-col">
            <h3 class="text-sm font-medium text-gray-900 hover:underline">
                <!-- <a :href="route(product.href)"> -->
                <a :href="route('product', product.id)">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ product.nombre }}
                </a>
            </h3>
            <div class="flex-1 flex flex-col justify-end">
                <div v-if="product.promo_active" class=" px-2 mb-6">
                    <div class="font-bold text-base text-red-500 line-through">{{ formatPrice(product.price_public) }}
                    </div>
                    <div class="font-extrabold text-2xl">{{ formatPrice(product.promo_price) }}</div>
                </div>

                <div v-else class=" px-2 mb-6">
                    <div class="font-extrabold text-2xl">{{ formatPrice(product.price_public) }}</div>
                </div>
                <!-- <p class="text-xl font-bold text-gray-900">$ {{ Number(product.price_public).toLocaleString(undefined, {
                    minimumFractionDigits: 0, maximumFractionDigits: 0
                }) }}</p> -->
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    setup() {
        return {
            // products,
            imageSrc: 'https://www.monsa-srl.com.ar/pedidosweb/resources/img/uploads/cascos/cascos_agv_k1_solid_black_ml1.jpg',
        }
    },
    methods: {
        buildImg(imagen) {
            let imageArray = JSON.parse(imagen);

            if (imageArray.length > 0) {
                // Asegura que la ruta de la imagen comience siempre con una barra '/'
                const imagePath = imageArray[0].startsWith('/') ? imageArray[0] : '/' + imageArray[0];
                const img = `https://www.monsa-srl.com.ar/pedidosweb${imagePath}`;
                return img;
            } else {
                return null;
            }
        },
        formatPrice(price_public) {
            const formattedPrice = price_public.toLocaleString('es-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });
            return formattedPrice;

        }
    }
}
</script>