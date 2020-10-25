require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('admin-home', require('./components/adminHomeComponent.vue').default);
Vue.component('admin-socios', require('./components/sociosComponent.vue').default);

const app = new Vue({
    el: '#app',
    
    data: {
        menu: 1,
    },
    methods: {

    } //cierre de methods  
});//cierre de const app->objet vue
