<template>
    <!-- eslint-disable -->
    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm">
        <td class="border-t px-4 py-2 text-left">{{ item.name }}</td>
        <td class="border-t px-4 py-2 text-left">{{ item.email }}</td>
        <td class="border-t px-4 py-2 text-left">
            <span v-for="role in item.roles" :key="role" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                {{ role }}
            </span>
        </td>
        <td class="border-t px-4 py-2 text-left">{{ formatDate(item.created_at) }}</td>
        <td class="border-t px-4 py-2 text-center">
            <div class="flex justify-center space-x-2">
                <!-- Botón Editar -->
                <button @click="toggleEdit"
                        title="Editar usuario"
                        class="text-blue-600 hover:text-blue-900">
                    <PencilIcon class="h-5 w-5" />
                </button>

                <!-- Botón Cambiar Contraseña -->
                <button @click="togglePasswordChange"
                        title="Cambiar contraseña"
                        class="text-green-600 hover:text-green-900">
                    <KeyIcon class="h-5 w-5" />
                </button>

                <!-- Botón Eliminar -->
                <button @click="confirmDelete"
                        title="Eliminar usuario"
                        class="text-red-600 hover:text-red-900">
                    <TrashIcon class="h-5 w-5" />
                </button>
            </div>
        </td>
    </tr>

    <!-- Modal para editar usuario -->
    <tr v-if="showEditForm" class="bg-gray-50">
        <td colspan="5" class="px-4 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" v-model="editForm.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" v-model="editForm.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button @click="cancelEdit" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Cancelar
                </button>
                <button @click="updateUser" class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </td>
    </tr>

    <!-- Modal para cambiar contraseña -->
    <tr v-if="showPasswordForm" class="bg-yellow-50">
        <td colspan="5" class="px-4 py-4">
            <div class="max-w-md">
                <label class="text-sm font-medium text-gray-700">Nueva Contraseña</label>
                <input type="password" v-model="passwordForm.password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <p class="mt-1 text-sm text-gray-500">Déjalo vacío para generar una contraseña aleatoria</p>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button @click="cancelPasswordChange" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Cancelar
                </button>
                <button @click="changePassword" class="px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                    Cambiar Contraseña
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
import { PencilIcon, KeyIcon, TrashIcon } from '@heroicons/vue/24/outline'

export default {
    props: {
        item: Object
    },

    components: {
        PencilIcon,
        KeyIcon,
        TrashIcon
    },

    data(){
        return {
            showEditForm: false,
            showPasswordForm: false,
            editForm: {},
            passwordForm: {
                password: ''
            }
        }
    },

    methods: {
        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        },

        toggleEdit() {
            this.showEditForm = !this.showEditForm;
            this.showPasswordForm = false;
            if (this.showEditForm) {
                this.editForm = {
                    name: this.item.name,
                    email: this.item.email
                };
            }
        },

        togglePasswordChange() {
            this.showPasswordForm = !this.showPasswordForm;
            this.showEditForm = false;
            this.passwordForm = { password: '' };
        },

        cancelEdit() {
            this.showEditForm = false;
            this.editForm = {};
        },

        cancelPasswordChange() {
            this.showPasswordForm = false;
            this.passwordForm = { password: '' };
        },

        async updateUser() {
            let data = {}
            try {
                const response = await axios.put(route('manager.users.update', this.item.id), this.editForm);
                if (response.status === 200) {
                    data.message = response.data.message || 'Usuario actualizado correctamente'
                    data.labelType = 'success'
                    this.showEditForm = false;
                    this.$emit('refresh');
                } else {
                    data.message = response.data.message || 'Error al actualizar usuario'
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
            }
            this.$emit('message', data)
        },

        async changePassword() {
            let data = {}
            try {
                const response = await axios.post(route('manager.users.changePassword', this.item.id), this.passwordForm);
                if (response.status === 200) {
                    data.message = response.data.message || 'Contraseña cambiada correctamente'
                    data.labelType = 'success'
                    this.showPasswordForm = false;
                } else {
                    data.message = response.data.message || 'Error al cambiar contraseña'
                    data.labelType = 'danger'
                }
            } catch (error) {
                data.message = 'Se ha producido un error al procesar | Comuníquese con el administrador'
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        },

        confirmDelete() {
            if (confirm('¿Está seguro que desea eliminar este usuario?')) {
                this.deleteUser();
            }
        },

        async deleteUser() {
            let data = {}
            try {
                const response = await axios.delete(route('manager.users.destroy', this.item.id));
                if (response.status === 200) {
                    data.message = response.data.message || 'Usuario eliminado correctamente'
                    data.labelType = 'success'
                    this.$emit('refresh');
                } else {
                    data.message = response.data.message || 'Error al eliminar usuario'
                    data.labelType = 'danger'
                }
            } catch (error) {
                data.message = 'Se ha producido un error al procesar | Comuníquese con el administrador'
                data.labelType = 'danger'
            }
            this.$emit('message', data)
        }
    }
}
</script>
