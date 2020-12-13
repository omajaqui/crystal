
require('./bootstrap');

import VueSelectImage from 'vue-select-image';
Vue.use(VueSelectImage);
require('vue-select-image/dist/vue-select-image.css');  

window.Vue = require('vue');
window.Vuex = require('vuex');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('login', require('./components/LoginComponent.vue').default);

//COMUN
Vue.component('comun-header', require('./components/headerComponent.vue').default); 
Vue.component('comun-reglas', require('./components/reglasComponent.vue').default);


//ADMINISTRADOR
Vue.component('admin-home', require('./components/adminHomeComponent.vue').default);
Vue.component('admin-socios', require('./components/adminSociosComponent.vue').default);
Vue.component('admin-cuotas', require('./components/cuotasComponent.vue').default);
Vue.component('admin-prestamos', require('./components/adminPrestamosComponent.vue').default);
Vue.component('form-socio', require('./components/formSocio.vue').default);  
Vue.component('admin-actividades', require('./components/adminActividadesComponent.vue').default); 

//FORMULARIOS
Vue.component('cuotas-mensual', require('./components/formCuotaMensual.vue').default);
Vue.component('cuotas-prestamo', require('./components/formCuotaPrestamo.vue').default);
Vue.component('cuotas-multas', require('./components/formCuotaMulta.vue').default);  

//COMPONENTES SOCIOS
Vue.component('socio-home', require('./components/socioHomeComponent.vue').default); 
Vue.component('socio-miahorro', require('./components/socioMiAhorroComponent.vue').default);

//PIPES
Vue.filter("mayusculas", v => (v || "").toString().toUpperCase());
Vue.filter("separadorMiles", v => v.replace(/(\d)(\d{3})($|,|\.)/g, '$1.$2$3') );


const store = new Vuex.Store({
    state: {
      tokenGlobal: '',
      idPersonaGlobal: '',
      nombreUsuario: '',
      nombreFoto:'', 
      ipInfo: [],     
    },
    mutations: {
      restablecer(state){
        state.tokenGlobal = '';
        state.idPersonaGlobal = '';
        state.nombreUsuario = '';
        state.nombreFoto = '';
      },
      
    }
});

const app = new Vue({
    el: '#app',
    store,
    
    /* components: {
      Multiselect: window.VueMultiselect
    }, */
    
    data: {
        menu: 1,
        token: '',
    },
    methods: {

    } //cierre de methods  
});//cierre de const app->objet vue
