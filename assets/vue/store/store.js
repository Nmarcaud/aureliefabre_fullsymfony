import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// Gestion des produits
const product = {
    namespaced: true,
    state: {
        datas: []
    },
    mutations: {
    }
}


// Gestion du cart
const cart = {
    namespaced: true,
    state: {
        datas: []
    },
    mutations: {
    }
}








const store = new Vuex.Store({
    modules: {
        product,
        cart,
    }
})

export default store;