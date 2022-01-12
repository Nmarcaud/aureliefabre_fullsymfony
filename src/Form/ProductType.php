<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isService', CheckboxType::class, [
                'label' => "S'agit-il d'un service ?",
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Tapez le nom du produit'
                    ]
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => [
                    'placeholder' => 'Tapez une courte description'
                    ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit',
                'attr' => [
                    'placeholder' => 'Tapez le prix du produit en euros'
                ],
                'divisor' => 100    // Ratio Euro / Centimes
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée du service',
                'attr' => [
                    'placeholder' => 'Tapez la durée en minutes'
                ]
            ])
            ->add('turnaroundTime', IntegerType::class, [
                'label' => 'Temps de battement',
                'attr' => [
                    'placeholder' => 'Tapez le temps de battement en minutes'
                ]
            ])
            ->add('isAvailableOnSite', CheckboxType::class, [
                'label' => "Disponible sur le site",
            ])
            ->add('isAvailableForAppointment', CheckboxType::class, [
                'label' => "Disponible à la prise de rendez-vous",
            ])
            ->add('mainPicture', UrlType::class, [
                'label' => 'Image du produit',
                'attr' => [
                    'placeholder' => 'Tapez une url d\'image'
                    ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'placeholder' => '-- Choisir une catégorie --',
                'class' => Category::class,
                'choice_label' => 'name',
            ]);   

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
