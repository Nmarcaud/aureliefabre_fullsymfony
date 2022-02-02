import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

// Gestion des produits
const product = {
    // Permet de bien différencier les modules
    namespaced: true,
    state: {
        datas: []
    },
    mutations: {
        // Ajouter plusieurs produits
        addMany(state, products){
            state.datas = products
        },
    },
    actions: {
        // Récupérations des produits
        fetchDatas(context) {
            axios.get('/products').then( res => {
                context.commit('addMany', res.data['hydra:member']);
                console.log(res.data['hydra:member']);
            })
        }
    },
   
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