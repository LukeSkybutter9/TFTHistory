require('./bootstrap');

import Vue from 'vue';
import store from './store';

// Registra los componentes
Vue.component('historial-component', require('./components/Historial.vue').default);
Vue.component('navegador-component', require('./components/Navbar.vue').default);

// Crear instancia de Vue
new Vue({
    el: '#app',
    store,
});