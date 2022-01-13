<?php 

namespace App\EntityListener;

use App\Entity\Product;
use Doctrine\ORM\Event\LifecycleEventArgs;
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

    public function prePersist(Product $product, LifecycleEventArgs $event)
    {
        if (empty($product->getSlug())){
            $this->computeSlug($product);
        }
    }

    public function preUpdate(Product $product, LifecycleEventArgs $event)
    {
        $this->computeSlug($product);
    }

}