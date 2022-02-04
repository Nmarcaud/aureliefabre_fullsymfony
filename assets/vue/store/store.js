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
        },
        fetchFilteredDatas(context) {
            axios.get('/products').then( res => {
               
                const productsList = res.data['hydra:member'];

                // Liste des ids des catégories filtrées
                const catergoriesIdList = context.rootState.shopFilters.categoriesFilters.map(category => { return category.id });


                let filteredProductsList = productsList;

                // Si filtre par catégorie
                if(catergoriesIdList.length > 0) {
                    // Liste filtrée
                    filteredProductsList = filteredProductsList.filter(product => catergoriesIdList.includes(product.category.id))
                }

                // Si prix mini
                const minPrice = context.rootState.shopFilters.minPrice;
                const minPriceSelected = context.rootState.shopFilters.minPriceSelected;
                if(minPrice !== minPriceSelected) {
                    filteredProductsList = filteredProductsList.filter(product => product.price / 100 > minPriceSelected)
                }

                // Si prix maxi
                const maxPrice = context.rootState.shopFilters.maxPrice;
                const maxPriceSelected = context.rootState.shopFilters.maxPriceSelected;
                if(maxPrice !== maxPriceSelected) {
                    filteredProductsList = filteredProductsList.filter(product => product.price / 100 < maxPriceSelected)
                }

                context.commit('addMany', filteredProductsList);
            })
        }

    },
   
}


// Gestion des Catégories
const category = {
    namespaced: true,
    state: {
        datas: []
    },
    mutations: {
        // Ajouter plusieurs catégories
        addMany(state, category){
            state.datas = category
        },
    },
    actions: {
        // Récupérations des catégories
        fetchDatas(context) {
            axios.get('/categories').then( res => {
                context.commit('addMany', res.data['hydra:member']);
                console.log(res.data['hydra:member']);
            })
        }
    },
   
}


// Gestion des Filtres du Shop
const shopFilters = {
    namespaced: true,
    state: {
        categoriesFilters: [],
        minPrice: 0,
        maxPrice: 250,
        minPriceSelected: 0,
        maxPriceSelected: 250,
        minDuration: 0,
        maxDuration: 120,
    },
    mutations: {
        // Price
        modifiedMinPriceRange(state, value){
            state.minPriceSelected = value;
        },
        modifiedMaxPriceRange(state, value){
            state.maxPriceSelected = value;
        },

        // Catégories
        addOneCategory(state, category) {
            console.log('Add');
            state.categoriesFilters.push(category)
        },
        removeOneCategory(state, category) {
            console.log('Remove');
            const index = state.categoriesFilters.indexOf(category);
            state.categoriesFilters.splice(index, 1);
        },
    },
    actions: {
        // Price
        updateMinPriceRange(context, value){
            context.commit('modifiedMinPriceRange', value);
        },
        updateMaxPriceRange(context, value){
            context.commit('modifiedMaxPriceRange', value);
        },

        // Catégorie
        upadteCategoriesFilters(context, category) {
            // If catégorie déjà présente...
            if(context.state.categoriesFilters.includes(category)) {
                context.commit('removeOneCategory', category);
            } else {
                context.commit('addOneCategory', category);
            }
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
        category,
        shopFilters,
        cart,
    }
})

export default store;