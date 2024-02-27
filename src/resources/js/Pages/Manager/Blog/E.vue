<template>
    <!-- eslint-disable -->
    <h1>{{ content }}</h1>
    <quill-editor :value="content" v-model:content="content" @change="onEditorChange($event)"></quill-editor>

  </template>
  
  <script>
  import { ref, defineComponent } from 'vue'
  import { quillEditor } from 'vue3-quill';

  export default defineComponent({
    props: {
      post: {
        type: Object,
        default: ''
      }
    },
    components: {
      quillEditor,
    },
    data() {
      return {
        content: this.post.content,
      }
    },
    setup: () => {
    //   const content = ref('')
  
    //   return { content }
    },
    methods: {
      onEditorChange({ quill, html, text }) {
        // console.log('editor change!', quill, html, text)
        this.content = html
      }      
    },
  })
  </script>