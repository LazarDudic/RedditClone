
require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('welcome-page', require('./components/WelcomePage.vue').default);
Vue.component('categories', require('./components/Categories.vue').default);
Vue.component('topic', require('./components/Topic.vue').default);

const app = new Vue({
    el: '#app',
});
