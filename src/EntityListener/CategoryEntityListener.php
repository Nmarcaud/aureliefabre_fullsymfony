<?php 

namespace App\EntityListener;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryEntityListener
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    protected function computeSlug(Category $category)
    {
        $category->setSlug(strtolower($this->slugger->slug($category->getName())));
    }

    public function prePersist(Category $category)
    {
        if (empty($category->getSlug())){
            $this->computeSlug($category);
        }
    }

    public function preUpdate(Category $category)
    {
        $this->computeSlug($category);
    }

}