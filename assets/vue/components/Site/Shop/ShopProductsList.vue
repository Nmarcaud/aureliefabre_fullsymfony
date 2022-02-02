<template>
    <div class="row">
        <shop-product-item v-for="product in products" :key="product.id" :product="product"></shop-product-item>
    </div>
</template>


<script>
import ShopProductItem from './ShopProductItem';
export default {
    name: 'ProductsList',
    props: ['products'],
    components: {
        ShopProductItem 
    }
};
</script>
