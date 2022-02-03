<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Durée</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <cart-product-item v-for="product in cart" :key="product.id" :product="product"></cart-product-item>
        </tbody>
        <tfoot>
            <td colspan="4">Total</td>
            <td colspan="2">{{ totalCartAmount / 100 }}€</td>
        </tfoot>
    </table>
</template>



<script>
import CartProductItem from './CartProductItem.vue';
import { mapGetters } from 'vuex';
export default {
    name: 'CartProductsList',
    props: ['cart'],
    components: {
        CartProductItem 
    },
    computed: {
        ...mapGetters('cart', ['totalCartAmount'])
    }
};
</script>
