<?php
// api/src/EventSubscriber/BookMailSubscriber.php

// Subscriber créé pour intervenir sur la création de Product et "formater" les images
// Sans succès pour le moment...

namespace App\EventSubscriber;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ImageUploadSubscriber implements EventSubscriberInterface
{


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['uplaodPicture', EventPriorities::PRE_WRITE],
        ];
    }

    public function uplaodPicture(ViewEvent $event): void
    {

        $product = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$product instanceof Product || Request::METHOD_POST !== $method) {
            return;
        }







        // Actions sur les images

        // $product = new Product;
        // $form = $this->createForm(ProductType::class, $product);
        
        // $form->handleRequest($request);

       
            // $this->em->persist($product);

            // $imageJpg = $form->get('jpgPicture')->getData();
            // if ($imageJpg) {
            //     // Rename image
            //     $newFilename = $product->getSlug() .'-'.uniqid().'.'.$imageJpg->guessExtension();
            //     // Move the file to the directory where brochures are stored
            //     try {
            //         $imageJpg->move(
            //             $this->getParameter('img_products_jpg'),
            //             $newFilename
            //         );
            //     } catch (FileException $e) {
            //         // ... handle exception if something happens during file upload
            //     }
            //     $product->setJpgPicturePath('/img/products/jpg/' . $newFilename);
            // }

            // $imageWebp = $form->get('webpPicture')->getData();
            // if ($imageWebp) {
            //     // Rename image
            //     $newFilename = $product->getSlug() .'-'.uniqid().'.'.$imageWebp->guessExtension();
            //     // Move the file to the directory where brochures are stored
            //     try {
            //         $imageWebp->move(
            //             $this->getParameter('img_products_webp'),
            //             $newFilename
            //         );
            //     } catch (FileException $e) {
            //         // ... handle exception if something happens during file upload
            //     }
            //     $product->setWebpPicturePath('/img/products/webp/' . $newFilename);
            // }


        
        // $book = $event->getControllerResult();
        // $method = $event->getRequest()->getMethod();

        // if (!$book instanceof Book || Request::METHOD_POST !== $method) {
        //     return;
        // }

        // $message = (new Email())
        //     ->from('system@example.com')
        //     ->to('contact@les-tilleuls.coop')
        //     ->subject('A new book has been added')
        //     ->text(sprintf('The book #%d has been added.', $book->getId()));

        // $this->mailer->send($message);
    }
}