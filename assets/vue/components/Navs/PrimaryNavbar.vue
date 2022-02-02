<template>
    <nav class="navbar navbar-expand-lg navbar-dark mx-0">
        <div class="container-xxl">
            <a class="navbar-brand" href="/" title="Logo de l'Institut">
                <img src="/img/logo/logo-2-af-blanc.svg" alt="Logo Aurélie Fabre Blanc" class="logo-navbar">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" title="Espace beauté">Navbar Vue</a>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/vue/shop">Boutique</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/vue/cart">Panier</router-link>
                    </li>
                     <li class="nav-item">
                        <router-link class="nav-link" to="/vue/admin">Admin</router-link>
                    </li>
                </ul>
                <button class="btn btn-primary ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Panier piano</button>

            </div>
        </div>
    </nav>

</template>



<script>
export default {
    name: 'PrimaryNavbar'
}
</script>