<template>
    <div>
        <the-header></the-header>
        <div class="container d-flex flex-row py-3">
            <router-view></router-view>
        </div>  
        <mini-cart></mini-cart>
    </div>
</template>



<script>

import TheHeader from './components/Navs/TheHeader';
import Cart from './components/Site/Cart/Cart';
import MiniCart from './components/Site/MiniCart/MiniCart';

export default {
    
    name: 'App',
    components: { 
        TheHeader,
        Cart,
        MiniCart,
    }
};
</script>
