<template>
    <div class="col-12">
        <hr>
        <div class="row mb-2">
            <div class="col-3">
                <img class="img-fluid w-shadow" :src="product.webpPicturePath" :alt="product.name">
            </div>
            <div class="col-9">
                <h6 class="fw-bold mb-0 d-flex">{{ product.name }} <a class="ms-auto dg-2" @click="deleteProduct(product.id)"><i class="fa-regular fa-times fa-fw"></i></a></h6>
                <small class="dg-1 mb-2">{{ product.price / 100 }}€ | {{ product.duration }}min</small>

                <div class="d-flex justify-content-between">
                    <p class="mb-1">Quantité : {{ product.quantity }}</p>
                    <p class="mb-1">Total : {{ totalItem }}</p>
                </div>
                
            </div>
        </div>
    </div>
</template>



<script>
import { mapMutations } from 'vuex';

export default {
    name: 'MiniCartProductItem',
    props: ['product'],
    computed: {
        totalItem(){
            return this.product.quantity * this.product.price / 100;
        },
    },
    methods: {
        ...mapMutations('cart', ['deleteProduct'])
    }

};
</script>
