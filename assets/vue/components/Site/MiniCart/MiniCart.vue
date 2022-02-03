<template>
    <div class="offcanvas offcanvas-end mini-cart" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Mini cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <mini-cart-products-list :cart=cart :total=totalCartAmount></mini-cart-products-list>
        </div>
    </div>
</template>


<script>
import MiniCartProductsList from './MiniCartProductsList';
import { mapState, mapGetters } from 'vuex';

export default {
    name: 'MiniCart',
    components: {
        MiniCartProductsList
    },
    computed: {
        ...mapState ('cart', {
            cart: 'datas'
        }),
        ...mapGetters('cart', ['totalCartAmount'])
    }
};
</script>
