<template>
    <div class="row">
        <shop-product-item></shop-product-item>
        <shop-product-item></shop-product-item>
        <shop-product-item></shop-product-item>
        <shop-product-item></shop-product-item>
        <shop-product-item></shop-product-item>
        <shop-product-item></shop-product-item>
    </div>
</template>



<script>
import ShopProductItem from './ShopProductItem';
export default {
    name: 'ProductsList',
    components: {
        ShopProductItem 
    }
};
</script>
