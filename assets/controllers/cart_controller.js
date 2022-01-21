import { Controller } from "@hotwired/stimulus"
import axios from "axios";

export default class extends Controller {
    add() {
        console.log('Ajouter au panier')

        // Récupération de l'id du produit pour ajout au panier
        let btn = this.element;
        let productId = this.element.dataset.productId;

        // Compteur Panier
        let countCartItems = document.querySelector('#countCartItem');

        // Récupération du texte et consersion en int
        let valueCountCartItems = parseInt(countCartItems.textContent);
        
        

        btn.textContent = 'Prestation ajoutée';

        setTimeout(() => {
            btn.textContent = 'Ajouter au panier';
        }, 1000);

        // Ajout au panier
        axios.put('/cart/add/' + productId).then(
            // Ajout et refresh du compteur
            valueCountCartItems += 1,
            console.log('Refresh du compteur : ' + valueCountCartItems),
            countCartItems.textContent = valueCountCartItems,
            
        )
    }


    show() {
        console.log('Affichage mini panier')


        // Récupération de l'id du produit pour ajout au panier
        let btn = this.element;
        let target = btn.dataset.bsTarget;
        console.log(target)
        // let productId = this.element.dataset.productId;

        // // Compteur Panier
        // let countCartItems = document.querySelector('#countCartItem');

        // // Récupération du texte et consersion en int
        // let valueCountCartItems = parseInt(countCartItems.textContent);
        
        

        // btn.textContent = 'Prestation ajoutée';

        // setTimeout(() => {
        //     btn.textContent = 'Ajouter au panier';
        // }, 1000);

        // // Ajout au panier
        // axios.put('/cart/add/' + productId).then(
        //     // Ajout et refresh du compteur
        //     valueCountCartItems += 1,
        //     console.log('Refresh du compteur : ' + valueCountCartItems),
        //     countCartItems.textContent = valueCountCartItems,
            
        // )
    }
}