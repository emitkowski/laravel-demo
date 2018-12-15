
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueClip from 'vue-clip'
Vue.use(VueClip);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('uploader', require('./components/Uploader.vue'));
Vue.component('attachment-list', require('./components/AttachmentList.vue'));
Vue.component('attachments', require('./components/Attachments.vue'));
Vue.component('addresses', require('./components/Addresses.vue'));

const app = new Vue({
    el: '#app'
});
