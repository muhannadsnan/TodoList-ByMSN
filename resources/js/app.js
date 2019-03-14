
require('./bootstrap');

window.Vue = require('vue');

Vue.component('Todo', require('./components/Todo.vue').default);

const app = new Vue({
    el: '#app'  
});
