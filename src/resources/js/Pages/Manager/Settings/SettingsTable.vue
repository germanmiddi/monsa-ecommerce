<template>
    <div>
        <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
        <section aria-labelledby="payment-details-heading" class="mt-6">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 sm:p-6">
                    <div>
                        <h2 id="payment-details-heading" class="text-lg leading-6 font-medium text-gray-900">Información
                            de contacto</h2>
                        <!-- <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating
                        your location could affect your tax rates.</p> -->
                    </div>

                    <div class="mt-6 grid grid-cols-4 gap-6">
                        <div class="col-span-4">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" v-model="email"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>

                        <div class="col-span-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="phone" id="phone" v-model="phone"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>

                        <div class="col-span-4">
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700">Whatsapp</label>
                            <input type="text" name="whatsapp" id="whatsapp" v-model="whatsapp"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>

                        <div class="col-span-4">
                            <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram</label>
                            <input type="text" name="instagram" id="instagram" v-model="instagram"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>

                        <div class="col-span-4">
                            <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook</label>
                            <input type="text" name="facebook" id="facebook" v-model="facebook"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>

                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button @click="saveSettingsContact()"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>
        </section>

        <section aria-labelledby="payment-details-heading" class="mt-6">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 sm:p-6">
                    <div>
                        <h2 id="payment-details-heading" class="text-lg leading-6 font-medium text-gray-900">Código JS
                        </h2>
                        <!-- <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating
                        your location could affect your tax rates.</p> -->
                    </div>

                    <div class="mt-6 grid grid-cols-4 gap-6">
                        <div class="col-span-4">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">Código HEAD</label>
                            <textarea name="code-head" id="code-head" v-model="codeHead" rows="15"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-4 gap-6">
                        <div class="col-span-4">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">Código BODY</label>
                            <textarea name="code-body" id="code-body" v-model="codeBody" rows="15"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" />
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button @click="saveSettingsCode()"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Toast from '@/Layouts/Components/Toast.vue'

export default {
    components: {
        Toast
    },
    data() {
        return {
            email: null,
            phone: null,
            whatsapp: null,
            instagram: null,
            facebook: null,
            codeHead: null,
            codeBody: null,
            toastMessage: null,
            labelType: null
        }
    },
    created() {
        this.getSettingsVarious()
    },
    methods: {
        clearMessage() {
            this.toastMessage = null
            this.labelType = null
        },

        async getSettingsVarious() {
            const url = route('settings.various')
            const response = await axios.get(url)
            console.log(response.data)

            this.email = response.data.find(setting => setting.key === 'email')?.value
            this.phone = response.data.find(setting => setting.key === 'phone')?.value
            this.whatsapp = response.data.find(setting => setting.key === 'whatsapp')?.value
            this.instagram = response.data.find(setting => setting.key === 'instagram')?.value
            this.facebook = response.data.find(setting => setting.key === 'facebook')?.value
            this.codeHead = response.data.find(setting => setting.key === 'code-head')?.value
            this.codeBody = response.data.find(setting => setting.key === 'code-body')?.value
        },

        async saveSettingsContact() {
            const url = route('settings.various.update')
            const response = await axios.post(url, {
                email: this.email,
                phone: this.phone,
                whatsapp: this.whatsapp,
                instagram: this.instagram,
                facebook: this.facebook
            })
            this.toastMessage = response.data.message
            this.labelType = response.data.type
        },

        async saveSettingsCode() {
            const url = route('settings.various.update')
            const response = await axios.post(url, {
                'code-head': this.codeHead,
                'code-body': this.codeBody
            })
            this.toastMessage = response.data.message
            this.labelType = response.data.type
        }
    }
}
</script>

<style></style>