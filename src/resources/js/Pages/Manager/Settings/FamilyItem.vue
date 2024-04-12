<template>
    <!-- eslint-disable -->

    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm ">
        <td class="border-t px-4 py-2 text-left">{{ item.nombre }}</td>
        <td class="border-t px-4 py-2 text-left">
            <Switch v-model="item.active"
                    @click="item.active = !item.active; updateFamily(item)"
                    :class="item.active ? 'bg-blue-600' : 'bg-gray-200'"
                    class="relative inline-flex h-6 w-11 items-center rounded-full">
                    <span :class="item.active ? 'translate-x-6' : 'translate-x-1'"
                        class="inline-block h-4 w-4 transform rounded-full bg-white transition"/>
            </Switch>                                                                                  
            

        </td>
    </tr>

</template>

<script>

import { Switch } from '@headlessui/vue'

export default {
    props: {
        item: Object
    },

    components: {
        Switch
    },

    data(){
        return {
            families: [],
        }
    },

    methods: {
        async updateFamily(item) {
            let response = await axios.post(route('settings.family.update', item))
            let data = response.data
            console.log(data)
        }
    },

}
</script>
