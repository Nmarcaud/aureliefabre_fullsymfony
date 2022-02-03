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
    getters: {
        totalCartItems(state){
            return state.datas.reduce((acc, p) => {
                acc += p.quantity
                return acc;
            }, 0)
        },
        totalCartAmount(state){
            return state.datas.reduce((acc, p) => {
                acc += p.price * p.quantity
                return acc;
            }, 0)
        },
    },
    mutations: {

        // Ajouter un produit
        addOne(state, product){
            // If Product in Cart
            if( state.datas.includes(product) ) {
                const index = state.datas.findIndex(d => d.id === product.id);
                state.datas[index].quantity += 1;
            } else {
                // Set Indispensble pour detection des changements par Vue
                Vue.set(product, 'quantity', 1);
                state.datas.push(product)
            }
            console.log(state.datas)
        },
        deleteOne(state, id) {
            // Retrouve index de l'élément
            const index = state.datas.findIndex(d => d.id === id);

            // Si il reste 1 article ( ou moins ! ) Supprime l'article
            if(state.datas[index].quantity <= 1) {
                state.datas.splice(index, 1);
            } else {
                state.datas[index].quantity -= 1;
            }
        },
        deleteProduct(state, id) {
            // Retrouve index de l'élément
            const index = state.datas.findIndex(d => d.id === id);
            state.datas.splice(index, 1);
        }
    },
    actions: {
        addOne(context, product) {
            context.commit('addOne', product);
        },
        deleteOne(context, id) {
            context.commit('deleteOne', id);
        },
        deleteProduct(context, id) {
            context.commit('deleteProduct', id);
        },
    }
}








const store = new Vuex.Store({
    modules: {
        product,
        cart,
    }
})

export default store;