<?php 

namespace App\EntityListener;

use App\Entity\Product;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductEntityListener
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    protected function computeSlug(Product $product)
    {
        $product->setSlug(strtolower($this->slugger->slug($product->getName())));
    }

    public function prePersist(Product $product)
    {
        if (empty($product->getSlug())){
            $this->computeSlug($product);
        }
    }

    public function preUpdate(Product $product)
    {
        $this->computeSlug($product);
    }

}