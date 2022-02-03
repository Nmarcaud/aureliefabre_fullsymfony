<template>
    <div class="container p-2">
        <h4>Shop</h4>
        <shop-products-list :products="products"></shop-products-list>
    </div>
</template>



<script>
import ShopProductsList from './ShopProductsList';
import { mapState } from 'vuex';

export default {
    name: 'Shop',
    components: {
        ShopProductsList
    },
    computed: {
        ... mapState('product', {
            products: 'datas'       // Objet avec alias
        })
    },
    created() {
        this.$store.dispatch('product/fetchDatas');
    }
};
</script>
