<template>
    <!-- TODO - Filtrer sur un booléen à mettre en base -->
    <div v-if="product.webpPicturePath" class="col-12 col-md-6 p-2 d-flex align-items-stretch">
        <div class="card border-0 w-100 w-shadow prestation">
            <div class="card-body d-flex flex-column">
                
                <!-- If webp -->
                <img v-if="product.webpPicturePath" class="img-fluid card-img-top mb-3" :src="product.webpPicturePath" alt="">
                <!-- Else -->
                <img v-else-if="product.jpgPicturePath" class="img-fluid card-img-top mb-3" :src="product.jpgPicturePath" alt="">

                <h4 class="card-title mb-0">{{ product.name }}</h4>
                <h5 class="dg-2">{{ product.price / 100 }}€ | {{ product.duration }}min</h5>
		        <span class="dg-1">{{ product.category.name }}</span>
                <p class="card-text">{{ product.shortDescription }}</p>

                <div class="mt-auto" >
                    <!-- <a href="#" class="btn btn-sm btn-secondary mt-2">Détails</a> -->
                    <a @click="addOne(product)" class="btn btn-sm btn-primary btn-add-cart mt-2">Ajouter au panier</a>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
import { mapMutations } from 'vuex';

export default {
    name: 'ProductItem',
    props: ['product'],
    methods: {
        ...mapMutations('cart', ['addOne'])
    }
};
</script>
