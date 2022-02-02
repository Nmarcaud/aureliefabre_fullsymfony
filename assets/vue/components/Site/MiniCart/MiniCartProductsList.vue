<template>
    <div class="row">
        <mini-cart-product-item></mini-cart-product-item>
        <mini-cart-product-item></mini-cart-product-item>
    </div>
</template>



<script>
import MiniCartProductItem from './MiniCartProductItem';
export default {
    name: 'MiniCartProductsList',
    components: {
        MiniCartProductItem 
    }
};
</script>
