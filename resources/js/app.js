/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

var num = 0;
$('#add').on('click', function() {

   var add_image = ' <input type="file" class="form-control-file text-dark"  name="image[]" id="File"  multiple="multiple">'
   $('.form-group-file').append(add_image)
   $(this).data("click", ++num);
    var click = $(this).data("click");
    if(click >= 4){
        $("#add").attr('disabled', true);
        alert("投稿できる画像は5枚までです");
    }
    return false;
});


      

  
