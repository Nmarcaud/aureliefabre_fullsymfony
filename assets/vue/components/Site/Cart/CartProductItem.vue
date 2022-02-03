<template>
    <tr>
        <td>{{ product.name }}</td>
        <td>{{ product.duration }}min</td>
        <td>{{ product.price / 100 }}€</td>
        <td>
            <a @click="deleteOne(product.id)"><i class="fa-regular fa-circle-minus fa-fw text-secondary"></i></a>
            {{ product.quantity }}
            <a @click="addOne(product)"><i class="fa-regular fa-circle-plus fa-fw text-secondary"></i></a>
        </td>
        <td>{{ totalItem }}€</td>
        <td><a class="ms-auto dg-2" @click="deleteProduct(product.id)"><i class="fa-regular fa-times fa-fw"></i></a></td>
    </tr>
</template>



<script>
import { mapActions } from 'vuex';

export default {
    name: 'CartProductItem',
    props: ['product'],
    computed: {
        totalItem(){
            return this.product.quantity * this.product.price / 100;
        },
    },
    methods: {
        ...mapActions('cart', ['addOne', 'deleteOne', 'deleteProduct']),
    }
};
</script>
