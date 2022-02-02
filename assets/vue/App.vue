<template>
    <div>
        <the-header></the-header>
        <div class="container d-flex flex-row py-3">
            <shop class="w-75"></shop>
            <cart class="w-25"></cart>
        </div>  
        
    </div>
</template>



<script>

import TheHeader from './components/Navs/TheHeader';
import Shop from './components/Site/Shop/Shop';
import Cart from './components/Site/Cart/Cart';

export default {
    
    name: 'App',
    components: { 
        TheHeader,
        Shop,
        Cart
    }
};
</script>
