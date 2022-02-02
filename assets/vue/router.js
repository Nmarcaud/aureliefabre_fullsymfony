import Vue from 'vue';
import VueRouter from 'vue-router';
import Shop from './components/Site/Shop/Shop';
import Cart from './components/Site/Cart/Cart';
import Admin from './components/Admin/Admin';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',        // Vrai système de route
    routes: [
        {
            path: '',
            redirect: '/vue/shop',
        },
        {
            path: '/vue/shop',
            component: Shop,
        },
        {
            path: '/vue/cart',
            component: Cart,
        },
        {
            path: '/vue/admin',
            component: Admin,
        },

        // Tous les autres paths
        {
            path: '**',
            redirect: '/vue/shop',
        },
    ]
        
});

export default router;