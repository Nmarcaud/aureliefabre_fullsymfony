<template>
    <div>
        
        <h3 class="mt-3 fs-4">Prix</h3>
        <label for="min_price_range" class="form-label">Prix minimum {{minPriceSelected}} €</label>
        <input id="min_price_range" type="range" class="form-range" :min="minPrice" :max="maxPrice" step="1" :value="minPriceSelected" @change="minPriceRange" />


        <label for="max_price_range" class="form-label mt-2">Prix maximum {{maxPriceSelected}}€</label>
        <input id="max_price_range" type="range" class="form-range" :min="minPrice" :max="maxPrice" step="1" :value="maxPriceSelected" @click="maxPriceRange" />
      

        <!-- <h3 class="mt-3 fs-4">Durée</h3>
        <input id="duration" class="multi-range" type="range" />
         -->
        
        <h3 class="mt-3 fs-4">Catégorie</h3>
        <div v-for="category in categories" :key="category.id" class="form-check">
            <input class="form-check-input" type="checkbox" :value="category.id" :id="category.id" @click="categoryFilter(category)">
            <label class="form-check-label" :for="category.id">
                {{ category.name }}
            </label>
        </div>

        <h3 class="mt-3 fs-4">Zone du corps</h3>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="visage">
            <label class="form-check-label" for="visage">
                Visage
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="...">
            <label class="form-check-label" for="...">
                ...
            </label>
        </div>

        <h3 class="mt-3 fs-4">Filtres sélectionnés {{ categoriesFilters.length }}</h3>
       
        <span v-if="minPrice !== minPriceSelected || maxPrice !== maxPriceSelected" class=" m-1 p-2 px-4 badge rounded-pill bg-secondary">
            <i class="fa-regular fa-money-bill-1-wave fa-fw me-1"></i>
            {{ minPriceSelected }}€ - {{ maxPriceSelected }}€
        </span>

        <span v-for="filter in categoriesFilters" :key="filter.name" class=" m-1 p-2 px-4 badge rounded-pill bg-secondary">
            <i class="fa-regular fa-tag fa-fw me-1"></i>
            {{ filter.name }}
        </span>
        
    </div> 
</template>


<script>
import { mapState } from 'vuex';

export default {
    name: 'ShopFilters',
    computed: {
        ... mapState('category', {
            categories: 'datas'       // Objet avec alias
        }),
        ... mapState('shopFilters', [
            'categoriesFilters', 
            'minPrice', 
            'maxPrice', 
            'minPriceSelected', 
            'maxPriceSelected',
            ])
    },
    methods: {
        minPriceRange(e) {
            this.$store.dispatch('shopFilters/updateMinPriceRange', e.target.value);
            this.$store.dispatch('product/fetchFilteredDatas');
        },
        maxPriceRange(e) {
            this.$store.dispatch('shopFilters/updateMaxPriceRange', e.target.value);
            this.$store.dispatch('product/fetchFilteredDatas');
        },
        categoryFilter(category) {
            this.$store.dispatch('shopFilters/upadteCategoriesFilters', category);
            this.$store.dispatch('product/fetchFilteredDatas');
        }
    },
    created() {
        this.$store.dispatch('category/fetchDatas');
    },
};
</script>
