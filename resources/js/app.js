require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('login', require('./components/LoginComponent.vue').default);
Vue.component('admin-home', require('./components/adminHomeComponent.vue').default);
Vue.component('admin-socios', require('./components/adminSociosComponent.vue').default);

//COMPONENTES SOCIOS
Vue.component('form-socio', require('./components/formSocio.vue').default);
Vue.component('editar-socio', require('./components/editarSocio.vue').default);

const store = new Vuex.Store({
    state: {
      numeroGlobal: 16,
      tokenGlobal: '',
      idPersonaGlobal: '',
    },
    mutations: {
      aumentar (state) {
        state.numeroGlobal++
      }
    }
});

const app = new Vue({
    el: '#app',
    store,
    
    data: {
        menu: 1,
        token: '',
    },
    methods: {

    } //cierre de methods  
});//cierre de const app->objet vue
