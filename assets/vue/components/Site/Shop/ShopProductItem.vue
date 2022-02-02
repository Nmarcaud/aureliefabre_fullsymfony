<template>
    <div class="col-12 col-md-6 col-lg-4 p-2">
        <div class="card border-0 w-100 w-shadow prestation">
            <div class="card-body d-flex flex-column">
                
                <!-- If webp -->
                <img class="img-fluid card-img-top mb-3" :src="product.img" alt="">
                <!-- Else -->

                <h4 class="card-title mb-0">{{ product.title }}</h4>
                <h5 class="dg-2">{{ product.price }}€ | {{ product.duration }}min</h5>
		        <span class="dg-1">{{ product.category }}</span>
                <p class="card-text">{{ product.description }}</p>

                <div class="mt-auto" >
                    <a href="#" class="btn btn-sm btn-secondary mt-2">Détails</a>
                    <a href="#" class="btn btn-sm btn-primary btn-add-cart mt-2">Ajouter au panier</a>
                </div>

            </div>
        </div>
    </div>
</template>



<script>
export default {
    name: 'ProductItem',
    data() { 
        return {
            product: {
                img: 'https://picsum.photos/id/' + this.getRandomArbitrary() + '/600',
                title: 'Une super prestation',
                price: '80', 
                duration: '60',
                category: 'Catégorie',
                description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate nihil, hic ratione vitae voluptatum excepturi atque unde temporibus iste. Laborum!',
            }
        }
    },
    methods: {
         getRandomArbitrary() {
            return Math.floor(Math.random() * (1000 - 1) + 1);
        }
    }
};
</script>
