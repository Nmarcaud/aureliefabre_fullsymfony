<template>
    <div class="container p-2">
        <h1>Boutique</h1>
        <div class="row">
            <div class="col-4">
                <shop-filters></shop-filters>
            </div>
            <div class="col-8">
                <shop-products-list :products="products"></shop-products-list>
            </div>
        </div>
    </div>
</template>



<script>
import ShopFilters from './ShopFilters';
import ShopProductsList from './ShopProductsList';
import { mapState } from 'vuex';

export default {
    name: 'Shop',
    components: {
        ShopFilters,
        ShopProductsList
    },
    computed: {
        ... mapState('product', {
            products: 'datas'       // Objet avec alias
        })
    },
    created() {
        this.$store.dispatch('product/fetchFilteredDatas');
    }
};
</script>
