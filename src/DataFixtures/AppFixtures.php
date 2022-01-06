<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use Liior\Faker\Prices;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    protected $slugger;
    private $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));
        

        dump('Création de l\'admin');

        $admin = new User;
        
        // Mot de passe encodé
        $hash = $this->encoder->hashPassword($admin, "password");

        $admin
            ->setEmail("admin@gmail.com")
            ->setFirstName('Nicolas')
            ->setLastName('Marcaud')
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN']);
    
        $manager->persist($admin);


        dump('Création des users');

        for ($u=0; $u < 5; $u++) { 
            $user = new User;
            
            // Mot de passe encodé
            $hash = $this->encoder->hashPassword($user, "password");

            $user
                ->setEmail("user$u@gmail.com")
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($hash)
                ->setRoles([]);

            $manager->persist($user);
        }


        dump('Création des catégories');

        dump('Beauté');
        
        $category = new Category;
        $category
            ->setName('Beauté')
            ->setSlug(strtolower($this->slugger->slug($category->getName())))
            ->setRank(1);
        $manager->persist($category);

            // Beauté
            $sousCategory = new Category;
            $sousCategory
                ->setName('Beauté')
                ->setSlug(strtolower($this->slugger->slug($sousCategory->getName())))
                ->setRank(1)
                ->setParentCategory($category);
            $manager->persist($sousCategory);

            // Épilations
            $sousCategory = new Category;
            $sousCategory
                ->setName('Épilations')
                ->setSlug(strtolower($this->slugger->slug($sousCategory->getName())))
                ->setRank(2)
                ->setParentCategory($category);
            $manager->persist($sousCategory);

            for($p = 0; $p < mt_rand(5, 20); $p++) {
                $product = new Product;
                $product
                    ->setName($faker->productName())
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($sousCategory)
                    ->setShortDescription($faker->sentence());
                $manager->persist($product);
            }

            // Manucures
            $sousCategory = new Category;
            $sousCategory
                ->setName('Manucures')
                ->setSlug(strtolower($this->slugger->slug($sousCategory->getName())))
                ->setRank(3)
                ->setParentCategory($category);
            $manager->persist($sousCategory);

            for($p = 0; $p < mt_rand(5, 20); $p++) {
                $product = new Product;
                $product
                    ->setName($faker->productName())
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($sousCategory)
                    ->setShortDescription($faker->sentence());
                $manager->persist($product);
            }

        
        dump('Bien-Être');

        $category = new Category;
        $category
            ->setName('Bien-Être')
            ->setSlug(strtolower($this->slugger->slug($category->getName())))
            ->setRank(2);
        $manager->persist($category);

            // Bien-Être
            $sousCategory = new Category;
            $sousCategory
                ->setName('Bien-Être')
                ->setSlug(strtolower($this->slugger->slug($sousCategory->getName())))
                ->setRank(1)
                ->setParentCategory($category);
            $manager->persist($sousCategory);

            // Massages de l'Institut
            $sousCategory = new Category;
            $sousCategory
                ->setName('Massages de l\'Institut')
                ->setSlug(strtolower($this->slugger->slug($sousCategory->getName())))
                ->setRank(2)
                ->setParentCategory($category);
            $manager->persist($sousCategory);

            for($p = 0; $p < mt_rand(5, 20); $p++) {
                $product = new Product;
                $product
                    ->setName($faker->productName())
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($sousCategory)
                    ->setShortDescription($faker->sentence())
                    ->setMainPicture($faker->imageUrl(400,400, true));
                $manager->persist($product);
            }

            // Massages du Monde
            $sousCategory = new Category;
            $sousCategory
                ->setName('Massages du Monde')
                ->setSlug(strtolower($this->slugger->slug($sousCategory->getName())))
                ->setRank(3)
                ->setParentCategory($category);
            $manager->persist($sousCategory);

            for($p = 0; $p < mt_rand(5, 20); $p++) {
                $product = new Product;
                $product
                    ->setName($faker->productName())
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($sousCategory)
                    ->setShortDescription($faker->sentence())
                    ->setMainPicture($faker->imageUrl(400,400, true));
                $manager->persist($product);
                
            }
        


        dump('Naturopathie');

        $category = new Category;
        $category
            ->setName('Naturopathie')
            ->setSlug(strtolower($this->slugger->slug($category->getName())))
            ->setRank(3);
        $manager->persist($category);


        $manager->flush();
    }
}
