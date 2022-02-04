<template>
    <div class="row">
        <mini-cart-product-item v-for="product in cart" :key="product.id" :product="product"></mini-cart-product-item>
        <hr v-if="cart.length > 0" class="mt-2">
        <div v-if="cart.length > 0" class="d-flex justify-content-end">
            <router-link class="btn btn-primary" to="/vue/cart" @click="hideOffcanvas">Valider mon panier {{ total / 100 }}€</router-link>
        </div>
    </div>
</template>


<script>
import MiniCartProductItem from './MiniCartProductItem';

export default {
    name: 'MiniCartProductsList',
    props: ['cart', 'total'],
    components: {
        MiniCartProductItem 
    },
    // methods: {
    //     hideOffcanvas() {
    //         console.log('Hide')
    //         let offcanvas = document.querySelector('#offcanvasRight');
    //         let back = document.querySelector('.offcanvas-backdrop')
    //         offcanvas.classList.remove("show");
    //         back.classList.remove("show");
    //     }
    // }
};
</script>
