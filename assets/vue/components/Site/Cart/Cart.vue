<template>
    <div class="container p-2">
        <h4>Panier</h4>
        <cart-products-list v-if="cart.length > 0" :cart="cart"></cart-products-list>
        <p v-else> Vous n'avez pas d'articles dans votre panier</p>
    </div>
</template>



<script>
import { mapState } from 'vuex';
import CartProductsList from './CartProductsList.vue';

export default {
    name: 'Cart',
    components: {
        CartProductsList 
    },
    computed: {
        ...mapState ('cart', {
            cart: 'datas'
        })
    }
};
</script>
