<template>
    <!-- eslint-disable -->
    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm">
        <td class="border-t px-2 py-2 text-left w-1/6">
            <button @click="viewCategory"
                    class="text-blue-600 hover:text-blue-900 hover:underline cursor-pointer truncate text-left w-full">
                {{ item.name }}
            </button>
        </td>
        <td class="border-t px-2 py-2 text-left w-1/6 hidden md:table-cell">
            <div class="truncate">{{ item.description }}</div>
        </td>
        <td class="border-t px-2 py-2 text-left w-16">
            <div v-if="item.image" class="w-8 h-8 overflow-hidden rounded">
                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
            </div>
            <span v-else class="text-gray-400 text-xs">Sin imagen</span>
        </td>
        <td class="border-t px-2 py-2 text-left w-20">
            <span :class="item.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                  class="px-2 py-1 text-xs rounded-full">
                {{ item.status === 'active' ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td class="border-t px-2 py-2 text-left w-1/6 hidden lg:table-cell">
            <div class="truncate">{{ item.meta_title }}</div>
        </td>
        <td class="border-t px-2 py-2 text-left w-1/6 hidden xl:table-cell">
            <div class="truncate">{{ item.meta_description }}</div>
        </td>
        <td class="border-t px-2 py-2 text-left w-20 hidden md:table-cell">
            <div class="truncate">{{ item.parent_id || 'Raíz' }}</div>
        </td>
        <td class="border-t px-2 py-2 text-center w-24">
            <div class="flex justify-center space-x-2">
                <!-- Botón Editar -->
                <button @click="toggleEdit"
                        title="Editar categoría"
                        class="text-blue-600 hover:text-blue-900">
                    <PencilIcon class="h-5 w-5" />
                </button>

                <!-- Botón Eliminar -->
                <button @click="confirmDelete"
                        title="Eliminar categoría"
                        class="text-red-600 hover:text-red-900">
                    <TrashIcon class="h-5 w-5" />
                </button>
            </div>
        </td>
    </tr>


</template>

<script>
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

export default {
    props: {
        item: Object
    },

    components: {
        PencilIcon,
        TrashIcon
    },

    data(){
        return {
            showEditForm: false,
            editForm: {}
        }
    },

    methods: {
        viewCategory() {
            // Navegar a la página single de la categoría
            this.$inertia.visit(route('categories.single', this.item.slug || this.item.id));
        },

        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        },

        toggleEdit() {
            this.showEditForm = !this.showEditForm;
            if (this.showEditForm) {
                this.editForm = {
                    name: this.item.name,
                    description: this.item.description,
                    status: this.item.status,
                    meta_title: this.item.meta_title,
                    meta_description: this.item.meta_description,
                    parent_id: this.item.parent_id
                };
            }
        },


        cancelEdit() {
            this.showEditForm = false;
            this.editForm = {};
        },

        async updateCategory() {
            let data = {}
            try {
                const response = await axios.put(route('manager.categories.update', this.item.id), this.editForm);
                if (response.status === 200) {
                    data.message = response.data.message || 'Categoría actualizada correctamente'
                    data.labelType = 'success'
                    this.showEditForm = false;
                    this.$emit('refresh');
                } else {
                    data.message = response.data.message || 'Error al actualizar categoría'
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

        confirmDelete() {
            if (confirm('¿Está seguro que desea eliminar esta categoría?')) {
                this.deleteCategory();
            }
        },

        async deleteCategory() {
            let data = {}
            try {
                const response = await axios.delete(route('manager.categories.destroy', this.item.id));
                if (response.status === 200) {
                    data.message = response.data.message || 'Categoría eliminada correctamente'
                    data.labelType = 'success'
                    this.$emit('refresh');
                } else {
                    data.message = response.data.message || 'Error al eliminar categoría'
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
