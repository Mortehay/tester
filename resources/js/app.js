
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

var VueScrollTo = require('vue-scrollto');
Vue.use(VueInternationalization);
Vue.use(VueScrollTo);

const lang = document.documentElement.lang.substr(0, 2);
const i18n = new VueInternationalization({
    locale: lang,
    fallbackLocale: 'en',
    messages: Locale
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('lang-switcher', require('./components/LangSwitcherComponent.vue').default);
Vue.component('domains', require('./components/DomainsComponent.vue').default);
Vue.component('domain-list', require('./components/DomainListComponent.vue').default);
Vue.component('domain', require('./components/DomainComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    i18n,
});
