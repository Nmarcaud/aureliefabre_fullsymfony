<?php 

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Storage\StorageInterface;

class ProductJpgImageController extends ProductController
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
        // if ($product->getJpgPicturePath()) 
        // {
        //     dump('Unlink');
        //     unlink ($this->storage->resolveUri($product, 'jpgPicture'));
        //     $this->storage->remove($product)
        // }


        $file = $request->files->get('file');

        // dump('Controller - pas de path');
        $product->setJpgPicture($file);

        // dump('Controller - essai ajout du path');
        $product->setJpgPicturePath($this->storage->resolveUri($product, 'jpgPicture'));

        // On doit absollument modifier le champ modifiedAt pour qu'un évènement Doctrine soir généré et notre ajout d'image pris en compte
        $product->setModifiedAt(new \DateTime());
        
        return $product;
    }
}