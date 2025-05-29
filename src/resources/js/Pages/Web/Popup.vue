<script setup>
import { ref, onMounted } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const bg = 'https://images.unsplash.com/photo-1658410439929-eb3fa8ddf053'
const open = ref(true)

const props = defineProps({
    content: Object
})

const link = ref(null)
const image = ref(null)
const active = ref(false)

onMounted(() => {
    console.log(props.content)
    link.value = props.content.find(item => item.element === 'link')?.content
    image.value = props.content.find(item => item.element === 'img')?.content
    active.value = props.content.find(item => item.element === 'active')?.content
})

const goToLink = () => {
    window.location.href = link.value
}
</script>

<template>
    <TransitionRoot as="template" :show="open" v-if="active">
      <Dialog class="relative z-10" @close="open = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-900/75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
              <DialogPanel class="relative transform overflow-hidden rounded-lg  text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg" :style="{ backgroundImage: `url(/storage/${image})`, backgroundSize: 'cover', backgroundPosition: 'center' }">

                                 <div class="flex w-[600px] h-[600px] cursor-pointer" @click="goToLink"></div>
                 <div class="absolute top-0 right-0 cursor-pointer bg-white/80 rounded-full p-2 hover:bg-white/90 transition-colors" @click="open = false">
                   <XMarkIcon class="w-6 h-6 text-gray-700" />
                 </div>

              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>
