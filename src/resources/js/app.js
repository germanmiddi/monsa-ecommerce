

require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Layout from './Layouts/Layout'
import LayoutWeb from './Layouts/LayoutWeb'
import { createPinia } from 'pinia'; //
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Monsa SRL';

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
//    resolve: (name) => require(`./Pages/${name}.vue`),
    resolve: name => {
        let page = require(`./Pages/${name}.vue`).default
        console.log(name)   
        if (name.includes('/Checkout/Index')){
            page.layout = ''
        }else if(name.startsWith('Manager')){
            page.layout = Layout
        }else if (name.startsWith('Web')){
            page.layout = LayoutWeb
        }

        // if(!page.layout && !name.startsWith('Auth') ){
        //     page.layout = Layout
        // }
        
        return page
    },

    setup({ el, app, props, plugin}) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(pinia) //  
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
