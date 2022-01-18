<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use Liior\Faker\Prices;
use App\Entity\Category;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use Symfony\Component\Asset\Package;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
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
        
        $package = new Package(new EmptyVersionStrategy());

        dump('Création de l\'admin');

        $admin = new User;
        
        // Mot de passe encodé
        $hash = $this->encoder->hashPassword($admin, "password");

        $admin
            ->setEmail("admin@gmail.com")
            ->setFirstName('Nicolas')
            ->setLastName('Marcaud')
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN'])
            ->setIsVerified(1)
            ->setProfilePicturePath('https://picsum.photos/300/300');
    
        $manager->persist($admin);


        dump('Création des users');

        $users = [];

        for ($u=0; $u < 2; $u++) { 
            $user = new User;
            
            // Mot de passe encodé
            $hash = $this->encoder->hashPassword($user, "password");

            $user
                ->setEmail("user$u@gmail.com")
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($hash)
                ->setRoles([])
                ->setIsVerified(1)
                ->setProfilePicturePath('https://picsum.photos/300/300');

            $users[] = $user;

            $manager->persist($user);
        }



        $products = [];

        dump('Création des catégories');

        dump('Beauté');
        

        // Beauté
        $category = new Category;
        $category
            ->setName('Beauté')
            ->setRank(1);
        $manager->persist($category);

        // Épilations
        $category = new Category;
        $category
            ->setName('Épilations')
            ->setRank(2);
        $manager->persist($category);

        // Manucures
        $category = new Category;
        $category
            ->setName('Manucures')
            ->setRank(3);
        $manager->persist($category);


    
    dump('Bien-Être');

        // Bien-Être
        $category = new Category;
        $category
            ->setName('Bien-Être')
            ->setRank(4);
        $manager->persist($category);

        // Massages de l'Institut
        $category = new Category;
        $category
            ->setName('Massages de l\'Institut')
            ->setRank(5);
        $manager->persist($category);

            // Découverte Corps
            $product = new Product;
            $product
                ->setName("Découverte Corps")
                ->setPrice(3500)
                ->setDuration(30)
                ->setTurnaroundTime(15)
                ->setIsService(true)
                ->setIsAvailableOnSite(true)
                ->setIsAvailableForAppointment(true)
                ->setCategory($category)
                ->setShortDescription("Un massage relaxant de la face dorsale avec une pression adaptée à chaque personne. Nous utilisons un baume de massage BIO ou une huile vierge BIO.")
                ->setMainPicturePath('/img/massages-de-linstitut/decouverte-corps-min.webp');
            $manager->persist($product);
            $products[] = $product;

            // Découverte Corps
            $product = new Product;
            $product
                ->setName("Gommage Corps")
                ->setPrice(3800)
                ->setDuration(30)
                ->setTurnaroundTime(15)
                ->setIsService(true)
                ->setIsAvailableOnSite(true)
                ->setIsAvailableForAppointment(true)
                ->setCategory($category)
                ->setShortDescription("Un gommage de tout le corps, comprenant une douche puis une application de lait hydratant pour le corps.")
                ->setMainPicturePath('/img/massages-de-linstitut/gommage-corps.webp');
            $manager->persist($product);
            $products[] = $product;



        // Massages du Monde
        $category = new Category;
        $category
            ->setName('Massages du Monde')
            ->setRank(6);
        $manager->persist($category);

            // Nuit Scandinave
            $product = new Product;
            $product
                ->setName("Nuit Scandinave")
                ->setPrice(7200)
                ->setDuration(60)
                ->setTurnaroundTime(15)
                ->setIsService(true)
                ->setIsAvailableOnSite(true)
                ->setIsAvailableForAppointment(true)
                ->setCategory($category)
                ->setShortDescription("Un massage Suédois relaxant et profond qui sollicite chaque segment musculaire afin de soulager, en douceur, vos tensions. Une playlist spécifique d’une heure a été conçue par une artiste Tourangelle ! Elle s'appelle Tilö.")
                ->setMainPicturePath('/img/massage-du-monde/massage-nuit-scandinave-min.webp');
            $manager->persist($product);
            $products[] = $product;

            // Bali Bali
            $product = new Product;
            $product
                ->setName("Bali Bali")
                ->setPrice(7200)
                ->setDuration(60)
                ->setTurnaroundTime(15)
                ->setIsService(true)
                ->setIsAvailableOnSite(true)
                ->setIsAvailableForAppointment(true)
                ->setCategory($category)
                ->setShortDescription("Un massage basé sur les codes de la médecine chinoise. Il est dynamique afin de renforcer la vitalité. Le but est de travailler la circulation sanguine et lymphatique.")
                ->setMainPicturePath('/img/massage-du-monde/massage-bali-bali-min.webp');
            $manager->persist($product);
            $products[] = $product;

            // Californien
            $product = new Product;
            $product
                ->setName("Californien")
                ->setPrice(7200)
                ->setDuration(60)
                ->setTurnaroundTime(15)
                ->setIsService(true)
                ->setIsAvailableOnSite(true)
                ->setIsAvailableForAppointment(true)
                ->setCategory($category)
                ->setShortDescription("Un massage du corps composé de manoeuvres amples et douces. Pour se détendre au quotidien. Il est particulièrement adapté aux personnes n’ayant jamais fait de massage en institut.")
                ->setMainPicturePath('/img/massage-du-monde/massage-californien-min.webp');
            $manager->persist($product);
            $products[] = $product;

            // Californien Réconfort
            $product = new Product;
            $product
                ->setName("Californien Réconfort")
                ->setPrice(9900)
                ->setDuration(90)
                ->setTurnaroundTime(15)
                ->setIsService(true)
                ->setIsAvailableOnSite(true)
                ->setIsAvailableForAppointment(true)
                ->setCategory($category)
                ->setShortDescription("Un massage complet, composé de manoeuvres amples et douces. Pour se détendre au quotidien. Il comprend, en plus du Californien, un massage du visage et du cuir chevelu. Il est particulièrement adapté aux personnes n’ayant jamais fait de massage en institut.")
                ->setMainPicturePath('/img/massage-du-monde/massage-californien-reconfort-min.webp');
            $manager->persist($product);
            $products[] = $product;
        


        dump('Naturopathie');

        $category = new Category;
        $category
            ->setName('Naturopathie')
            ->setRank(7);
        $manager->persist($category);



        dump('Purchases');

        for ($p=0; $p < mt_rand(20, 40); $p++) { 

            $totalPurchase = 0;

            $purchase = new Purchase;

            $purchase
                ->setFullName($faker->name)
                ->setAddress($faker->streetAddress)
                ->setZipCode($faker->postcode)
                ->setCity($faker->city)
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                

                // Faker récupère un user aléatoire dans la liste créée précdemment
                ->setUser($faker->randomElement($users));

            // Ajout de produits à nos commandes
            // Faker récupère PLUSIEURS products aux hasard
            $selectedProducts = $faker->randomElements($products, mt_rand(2,5));
            
            // Pour chaque product, créer une ligne de la commande
            foreach ($selectedProducts as $product) {

                $purchaseItem = new PurchaseItem;
                
                $purchaseItem
                    ->setPurchase($purchase)
                    ->setProduct($product)
                    ->setProductName($product->getName())
                    ->setProductPrice($product->getPrice())
                    ->setQuantity(mt_rand(1,3))
                    ->setTotal($purchaseItem->getProductPrice() * $purchaseItem->getQuantity());

                $purchase->addPurchaseItem($purchaseItem);

                $manager->persist($purchaseItem);

                $totalPurchase += $purchaseItem->getTotal();
            }

            // Faker retourne un booléen à 90% True
            if($faker->boolean(90)) {
                $purchase->setStatus(Purchase::STATUS_PAID);
            }

            $purchase->setTotal($totalPurchase);

            $manager->persist($purchase);
            
        }

        $manager->flush();
    }
}
