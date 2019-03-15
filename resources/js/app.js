
require('./bootstrap');

window.Vue = require('vue');

// TOASTR:  https://www.npmjs.com/package/vue-toastr-2
import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css' 
window.toastr = require('toastr') 
Vue.use(VueToastr2)
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "2000",
    "extendedTimeOut": "10000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

Vue.component('Todos', require('./components/Todos.vue').default);
Vue.component('Items', require('./components/Items.vue').default);

const app = new Vue({
    el: '#app'  
});
