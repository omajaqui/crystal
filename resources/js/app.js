require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    /* components: {
        Multiselect: window.VueMultiselect.default
    }, */
    data: {
        menu: 2,
    },
    methods: {

    } //cierre de methods  
});//cierre de const app->objet vue
