<template>
    <div class="p-2">
        <h4>Shop</h4>
        <shop-products-list></shop-products-list>
    </div>
</template>



<script>
import ShopProductsList from './ShopProductsList';

export default {
    name: 'Shop',
    components: {
        ShopProductsList
    }
};
</script>
