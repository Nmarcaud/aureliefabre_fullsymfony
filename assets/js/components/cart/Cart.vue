<template>
    <div class="container py-5">
        <h1>Panier Vue</h1>

        {{ items }}

        <!-- <ul>
            <li v-for="item in items" :key="item">{{item}}</li>
        </ul> -->

        <!-- Transmettre la commande -->
    
        <!-- Afficher les détails de la commande -->

        <!-- Actions suppression, modifications sur le panier -->

        <!-- Valider le Panier -->

        <hr>
    </div>
</template>

<script>

    export default {
        name: 'Cart',
        props: ['items'],
    }

</script>