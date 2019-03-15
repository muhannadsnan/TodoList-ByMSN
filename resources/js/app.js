
require('./bootstrap');

window.Vue = require('vue');

Vue.component('Todos', require('./components/Todos.vue').default);
Vue.component('Items', require('./components/Items.vue').default);

const app = new Vue({
    el: '#app'  
});
