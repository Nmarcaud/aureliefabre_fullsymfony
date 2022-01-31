<?php 

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

class ProductJpgImageController 
{
    public function __invoke(Product $product, Request $request)
    {

        if (!$product instanceof Product) {
            throw new \RuntimeException('Produit/service attendu');
        }
        $file = $request->files->get('file');

        // TODO - Si il y a déjà un fichier, le supprimer 



        $product->setJpgPicture($file);

        // On doit absollument modifier le champ modifiedAt pour qu'un évènement Doctrine soir généré et notre ajout d'image pris en compte
        $product->setModifiedAt(new \DateTime());
        
        return $product;
    }
}