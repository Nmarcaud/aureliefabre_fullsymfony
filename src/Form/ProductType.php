<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'required' => false
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Nom du produit'
                    ]
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => [
                    'placeholder' => 'Courte description'
                ],
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit',
                'attr' => [
                    'placeholder' => 'Prix du produit en euros'
                ],
                'divisor' => 100,    // Ratio Euro / Centimes
                'required' => false,
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée du service',
                'attr' => [
                    'placeholder' => 'Durée en minutes'
                ],
                'required' => false,
            ])
            ->add('turnaroundTime', IntegerType::class, [
                'label' => 'Temps de battement',
                'attr' => [
                    'placeholder' => 'Temps de battement en minutes'
                ],
                'required' => false,
            ])
            ->add('isAvailableOnSite', CheckboxType::class, [
                'label' => "Disponible sur le site",
                'required' => false,
            ])
            ->add('isAvailableForAppointment', CheckboxType::class, [
                'label' => "Disponible à la prise de rendez-vous",
                'required' => false,
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image du produit',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de respecter le format .jpg ou .png',
                    ])
                ],
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
