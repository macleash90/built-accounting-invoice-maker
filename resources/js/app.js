/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueProgressBar from "vue-progressbar";
import swal from "sweetalert2";

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
    background: '#2183d5',

    onOpen: toast => {
        toast.addEventListener("mouseenter", swal.stopTimer);
        toast.addEventListener("mouseleave", swal.resumeTimer);
    }
});
Vue.use(VueProgressBar, {
    // color: 'rgb(143,255,199)',
    color: "yellow",
    failedColor: "red",
    height: "6px"
});

window.toast = toast;
// window.Fire = new Vue();
// Add a response interceptor
axios.interceptors.response.use(
    function (response) {
        // Any status code that lie within the range of 2xx cause this function to trigger
        // Do something with response data
        return response;
    },
    function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        if (error.response.status == "404") {
            toast.fire({
                icon: "error",
                title: "Sorry the resource you requested could not be found"
            });
        }

        //logout user if unauthenticated
        if (error.response.status == "401" || error.response.status == "419") {
            swal.fire({
                title: "Session Expired",
                text: "You've been logged out, please log back in",
                icon: "warning",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
                allowOutsideClick: false
            }).then(result => {
                if (result.value) {
                    window.location.reload();
                }
            });
        }
        return Promise.reject(error);
    }
);


// define a mixin object

Vue.mixin({
    methods: {
        isEmpty: function (strIn) {
            if (strIn === undefined) {
                return true;
            }
            else if (strIn == null) {
                return true;
            }
            else if (strIn == "") {
                return true;
            }
            else {
                return false;
            }
        },
        isEmptyObject: function(obj)
        {
            Object.keys(obj).length === 0
        },
        getCurrentDateTime: function() {
            var now     = new Date(); 
            var year    = now.getFullYear();
            var month   = now.getMonth()+1; 
            var day     = now.getDate();
            var hour    = now.getHours();
            var minute  = now.getMinutes();
            var second  = now.getSeconds(); 
            if(month.toString().length == 1) {
                 month = '0'+month;
            }
            if(day.toString().length == 1) {
                 day = '0'+day;
            }   
            if(hour.toString().length == 1) {
                 hour = '0'+hour;
            }
            if(minute.toString().length == 1) {
                 minute = '0'+minute;
            }
            if(second.toString().length == 1) {
                 second = '0'+second;
            }   
            var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
             return dateTime;
        },
        to_2dp: function(number_)
        {
            if(isNaN(number_))
            {
                return 0.00;
            }
            else
            {
                return  Math.round((number_ + Number.EPSILON) * 100) / 100

            }
         }
    }
  })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//global components

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component("errors", require("./components/Errors").default);
Vue.component("star", require("./components/Star").default);


//components for specific pages

Vue.component('items-create', require('./pages/items/ItemsCreate').default);
Vue.component('items-edit', require('./pages/items/ItemsEdit').default);
Vue.component('items-view', require('./pages/items/ItemsView').default);

Vue.component('customers-create', require('./pages/customers/CustomersCreate').default);
Vue.component('customers-edit', require('./pages/customers/CustomersEdit').default);
Vue.component('customers-view', require('./pages/customers/CustomersView').default);

Vue.component('invoice-create', require('./pages/invoices/InvoiceCreate').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
