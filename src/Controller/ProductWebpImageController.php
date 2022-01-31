<?php 

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Storage\StorageInterface;

class ProductWebpImageController extends ProductController
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(Product $product, Request $request)
    {

        if (!$product instanceof Product) {
            throw new \RuntimeException('Produit/service attendu');
        }

        // TODO - Si il y a déjà un fichier, le supprimer 
        // Remove avec Vich ?

        $file = $request->files->get('file');

        $product->setWebpPicture($file);

        $product->setWebpPicturePath($this->storage->resolveUri($product, 'webpPicture'));

        // On doit absollument modifier le champ modifiedAt pour qu'un évènement Doctrine soir généré et notre ajout d'image pris en compte
        $product->setModifiedAt(new \DateTime());

        return $product;
    }
}