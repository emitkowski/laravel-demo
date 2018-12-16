
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Spark = [];
window.moment = require('moment');
window.Vue = require('vue');

import VueClip from 'vue-clip'
Vue.use(VueClip);

import Tabs from 'vue-tabs-component';
Vue.use(Tabs);

require('./filters');

require('./forms/bootstrap');

Vue.component('team-grid', require('./components/Teams/TeamGrid.vue'));
Vue.component('team-edit', require('./components/Teams/TeamEdit.vue'));

Vue.component('player-grid', require('./components/Players/PlayerGrid.vue'));
Vue.component('player-edit', require('./components/Players/PlayerEdit.vue'));

Vue.component('uploader', require('./components/Uploader.vue'));
Vue.component('attachment-list', require('./components/AttachmentList.vue'));
Vue.component('attachments', require('./components/Attachments.vue'));
Vue.component('addresses', require('./components/Addresses.vue'));

const app = new Vue({
    el: '#app'
});
