/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";
import { createApp } from "vue";
import PrimeVue from "primevue/config";
import { createMemoryHistory, createRouter } from "vue-router";
import { routes } from "@/router/routes";
import Aura from '@primevue/themes/aura';
// import Aura from "@/presets/aura";
import { i18nVue } from 'laravel-vue-i18n'
import ToastService from 'primevue/toastservice';
import AxiosConfig from '@/config/axios-config';

const router = createRouter({
	history: createMemoryHistory(),
	routes,
});

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: 'system',
            // cssLayer: false
        }
    }
});

import AppComponent from "@/views/App.vue";

app.component("app", AppComponent);
app.use(router);
app.use(ToastService);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.use(i18nVue, {
	resolve: async (lang:string) => {
		// @ts-expect-error
		const langs = import.meta.glob('../lang/*.json');
		return await langs[`../lang/${lang}.json`]();
	}
})

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app".
 */
app.mount("#app");

AxiosConfig.axiosSetUp();

