import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        darkMode: false, // Estado para el modo oscuro
    },
    mutations: {
        toggleDarkMode(state) {
            state.darkMode = !state.darkMode;
        }
    },
    actions: {
        toggleDarkMode({ commit }) {
            commit('toggleDarkMode'); 
        }
    },
    getters: {
        darkMode: state => state.darkMode,
    }
});
