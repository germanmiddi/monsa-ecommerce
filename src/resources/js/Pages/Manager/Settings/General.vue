<template>
    <Toast :toast="this.toastMessage" :type="this.labelType" @clear="clearMessage"></Toast>
    <!-- eslint-disable -->
    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-3">
                        <div class="px-4 sm:px-0 flex justify-between items-center mb-3">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Importación de datos</h3>
                        </div>
                    </div>
                </div>
                <div class="mt-5">

                    <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                        <div>
                            Sincronización de Familias<br>
                            <span class="text-gray-400 text-sm">Última ejecución {{ lastImportFamilies }}</span>
                        </div>
                        <button @click="getFamilies()"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                        <div>
                            Sincronización de Marcas<br>
                            <span class="text-gray-400 text-sm">Última ejecución {{ lastImportBrands }}</span>
                        </div>
                        <button @click="getBrands()"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                        <div>
                            Sincronización de Atributos<br>
                            <span class="text-gray-400 text-sm">Última ejecución {{ lastImportAtributes }}</span>
                        </div>
                        <button @click="getAtributes()"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                        <div>
                            Sincronización de Productos<br>
                            <span class="text-gray-400 text-sm">Última ejecución {{ lastImportProducts }}</span>
                        </div>
                        <button @click="getProducts()"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ejecturar</button>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                        <div>
                            Importar detalles de productos<br>
                            <input @change="handleFileChange" accept=".xlsx" type="file" name="file" id="file" ref="inputfile" autocomplete="off"
                                class="mt-2 bg-gray-100 focus:ring-indigo-500 focus:border-indigo-500 block" />
                           
                        </div>
                        <div>
                            <a :href="route('products.download.template')"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-indigo-800 bg-indigo-200 hover:bg-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">Template</a>
                            <button @click="importProducts()"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Importar</button>
                        </div>
                    </div>

                    <div v-if="result" class="flex justify-between items-center border-t border-gray-100 pt-3 mt-4">
                        <div>
                            Resultado de la importación<br>
                            <div > 
                                <p>Total de filas: {{ result.rows }}</p>
                                <p>Total de filas exitosas: {{ result.rowsSuccess }}</p>
                                <p>Total de filas con errores: {{ result.rowsError }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <SettingsTable  />
      
    </div>
</template>

<script>
import Toast from '@/Layouts/Components/Toast.vue'
import SettingsTable from './SettingsTable.vue'

export default {
    components: {
        Toast,
        SettingsTable
    },
    data() {
        return {
            toastMessage: "",
            labelType: "info",
            lastImportProducts: null,
            lastImportFamilies: null,
            lastImportBrands: null,
            lastImportAtributes: null,
            file: '',
            result: null,
        }
    },
    created() {
        this.getSettings()
    },

    methods: {
        clearMessage() {
            this.toastMessage = "";
        },

        async getFamilies() {

            const url = route('import.families')

            try {
                const response = await axios.get(url)
                if (response.status == 200) {
                    this.toastMessage = response.data.message
                    this.labelType = 'success'
                    this.getSettings()
                } else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
                }
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }

        },

        async getBrands() {

            const url = route('import.brands')
            try {
                const response = await axios.get(url)
                if (response.status == 200) {
                    this.toastMessage = response.data.message
                    this.labelType = 'success'
                    this.getSettings()
                } else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
                }
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }
        },

        async getAtributes() {

            const url = route('import.atributes')

            try {
                const response = await axios.get(url)
                if (response.status == 200) {
                    this.toastMessage = response.data.message
                    this.labelType = 'success'
                    this.getSettings()
                } else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
                }
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }

        },

        async getProducts() {

            const url = route('import.products')

            this.labelType = 'info';
            this.toastMessage = 'Se ha inciado proceso de importación de producto';

            try {
                const response = await axios.get(url)
                if (response.status == 200) {
                    this.toastMessage = response.data.message
                    this.labelType = 'success'
                    this.getSettings()
                } else {
                    this.toastMessage = response.data.message
                    this.labelType = 'danger'
                }
            } catch (error) {
                this.toastMessage = 'Se ha producido un error al procesar | Comuniquese con el administrador'
                this.labelType = 'danger'
            }

        },

        async getSettings() {
            const url = route('settings.import')
            const response = await axios.get(url)
            console.log(response.data)

            this.lastImportFamilies = response.data.find(setting => setting.key === 'last_import_families')?.value
            this.lastImportProducts = response.data.find(setting => setting.key === 'last_import_product')?.value
            this.lastImportBrands = response.data.find(setting => setting.key === 'last_import_brand')?.value
            this.lastImportAtributes = response.data.find(setting => setting.key === 'last_import_attributes')?.value

        },

        handleFileChange(event) {
            this.file = event.target.files[0];
        },

        async importProducts() {
            if (this.file != '') {
                // this.processImport = true
                // this.status = ''
                let rt = route("products.importDetails");
                const formData = new FormData();
                formData.append('file', this.file);
                try {
                    const response = await axios.post(rt, formData);
                    if (response.status == 200) {
                        this.result = response.data.result;
                        this.labelType = "success";
                        this.toastMessage = response.data.message;
                    } else {
                        this.labelType = "danger";
                        this.toastMessage = response.data.message;
                    }
                    // this.formImport = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.labelType = "info";
                this.toastMessage = "Debe seleccionar un archivo";
            }
        },

    }
}


</script>
