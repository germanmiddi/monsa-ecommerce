<template>
    <!-- eslint-disable -->
    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="flex-1 min-w-0 flex items-center md:col-span-3">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Administración de Usuarios</h3>
                        <a title="Nuevo usuario" @click="showCreate=!showCreate">
                            <MinusCircleIcon v-if=showCreate class="ml-2 w-6 h-6 text-red-700" />
                            <PlusCircleIcon v-else class="ml-2 w-6 h-6 text-blue-700" />
                        </a>
                    </div>
                </div>

                <!-- Formulario para crear nuevo usuario -->
                <div v-show="showCreate" class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="text-sm font-medium leading-6 text-gray-900">Nombre</label>
                            <div class="mt-2.5">
                                <input type="text" v-model="form.name" name="name" id="name" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed" />
                            </div>
                        </div>
                        <div>
                            <label for="email" class="text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2.5">
                                <input type="email" v-model="form.email" name="email" id="email" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed" />
                            </div>
                        </div>
                        <div>
                            <label for="role_id" class="text-sm font-medium leading-6 text-gray-900">Rol</label>
                            <div class="mt-2.5">
                                <select v-model="form.role_id" name="role_id" id="role_id" :disabled="loading" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="">Selecciona un rol</option>
                                    <option v-for="role in roles" :value="role.id" :key="role.id">{{ role.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="storeUser()"
                                :disabled="loading"
                                :class="[
                                    'flex-shrink-0 mt-4 relative inline-flex items-center px-4 py-2 shadow-sm text-xs font-medium rounded-md',
                                    loading
                                        ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                        : 'bg-blue-200 text-blue-900 hover:bg-blue-600 hover:text-white'
                                ]">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ loading ? 'Creando usuario...' : 'Guardar' }}
                        </button>
                    </div>
                </div>

                <!-- Tabla de usuarios -->
                <div class="md:col-span-3 mt-5">
                    <table class="w-full whitespace-nowrap">
                        <tr class="text-left font-bold bg-blue-500 text-white">
                            <th class="px-6 py-3 text-left">Nombre</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Roles</th>
                            <th class="px-6 py-3 text-left">Fecha Registro</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                        <UserItem v-for="item in users"
                                        :key="item.id"
                                        :item="item"
                                        @message="messageToast"
                                        @refresh="getUsers"/>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserItem from './UserItem.vue'
import { PlusCircleIcon, MinusCircleIcon } from '@heroicons/vue/24/outline'

export default {

    components: {
        UserItem,
        PlusCircleIcon,
        MinusCircleIcon
    },

    data(){
        return {
            users: [],
            form: {},
            showCreate: false,
            roles: [],
            loading: false
        }
    },

    methods: {
        async getRoles() {
            try {
                let response = await axios.get(route('manager.roles.list'))
                this.roles = response.data
            } catch (error) {
                console.error('Error getting roles:', error)
            }
        },

        async getUsers() {
            try {
                let response = await axios.get(route('manager.users.listForSettings'))
                this.users = response.data
                console.log('Users loaded:', this.users) // Debug
            } catch (error) {
                console.error('Error getting users:', error)
                let data = {
                    message: 'Error al cargar los usuarios',
                    labelType: 'danger'
                }
                this.$emit('message', data)
            }
        },

        async storeUser() {
            let data = {}
            this.loading = true; // Activar loader

            try {
                const response = await axios.post(route('manager.users.store'), this.form);
                if (response.status == 200) {
                    data.message = response.data.message
                    data.labelType = 'success'
                    this.showCreate = false
                } else {
                    data.message = response.data.message
                    data.labelType = 'danger'
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    data.message = 'Por favor revise los datos ingresados'
                    data.labelType = 'danger'
                } else {
                    data.message = 'Se ha producido un error al procesar | Comuníquese con el administrador'
                    data.labelType = 'danger'
                }
            } finally {
                this.loading = false; // Desactivar loader
            }

            this.form = {}
            this.getUsers();
            this.$emit('message', data)
        },

        messageToast(data){
            this.$emit('message', data)
        }
    },

    created() {
        this.getUsers();
        this.getRoles();
    },

}
</script>
