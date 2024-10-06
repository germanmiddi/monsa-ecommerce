<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <transition name="slide-fade">
    <div v-if="message && this.visible" 
         :class="alertClasses" 
         class="rounded-md p-4 border w-full mx-auto transform mt-2">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <CheckCircleIcon v-if="type === 'success'" class="h-5 w-5 text-green-800" aria-hidden="true" />
          <ExclamationCircleIcon v-if="type === 'warning'" class="h-5 w-5 text-yellow-800" aria-hidden="true" />
          <div class="ml-3">
            <div :class="textClasses">{{message}}</div>
          </div>
        </div>
        
        <button @click="visible=false" :class="buttonClasses">
          <XMarkIcon class="h-5 w-5" aria-hidden="true" />
        </button>
        
      </div>
    </div>
  </transition>
</template>

<script>
import { CheckCircleIcon, XMarkIcon, ExclamationCircleIcon } from '@heroicons/vue/24/outline'

export default {
  components: {
    CheckCircleIcon,
    XMarkIcon,
    ExclamationCircleIcon    
  },
  props: {
    message: String,
    type: {
      type: String,
      default: 'success'
    }    
  },
  computed: {
    alertClasses() {
      return {
        'bg-green-100 border-green-600': this.type === 'success',
        'bg-yellow-100 border-yellow-600': this.type === 'warning'
      }
    },
    textClasses() {
      return {
        'text-green-800': this.type === 'success',
        'text-yellow-800': this.type === 'warning'
      }
    },
    buttonClasses() {
      return {
        'text-green-800': this.type === 'success',
        'text-yellow-800': this.type === 'warning'
      }
    }
  },
  watch: {
    message: {
      handler: function () {
        this.visible = true
        if (this.timeOut) {
          clearTimeout(this.timeOut)
        }
        this.timeOut = setTimeout(() => {
          this.visible = false
          this.$emit("clear")
        }, 3000)
      },
      deep: true
    }
  },
  data() {
    return {
      visible: false,
      timeOut: null
    }
  },

}
</script>
<style>
/*
  Enter and leave animations can use different
  durations and timing functions.
  */
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(30px);
  /* Cambiado de translateX a translateY */
  opacity: 0;
}
</style>