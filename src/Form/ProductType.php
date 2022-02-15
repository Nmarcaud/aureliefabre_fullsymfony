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
                'label' => "S'agit-il d'un service ? - optionnel",
                'required' => false
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du produit - obligatoire',
                'attr' => [
                    'placeholder' => 'Nom du produit'
                    ]
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte - optionnel',
                'attr' => [
                    'placeholder' => 'Courte description'
                ],
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit - optionnel',
                'attr' => [
                    'placeholder' => 'Prix du produit en euros'
                ],
                'divisor' => 100,    // Ratio Euro / Centimes
                'required' => false,
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée du service - optionnel',
                'attr' => [
                    'placeholder' => 'Durée en minutes'
                ],
                'required' => false,
            ])
            ->add('turnaroundTime', IntegerType::class, [
                'label' => 'Temps de battement - optionnel',
                'attr' => [
                    'placeholder' => 'Temps de battement en minutes'
                ],
                'required' => false,
            ])
            ->add('isAvailableOnSite', CheckboxType::class, [
                'label' => "Disponible sur le site - optionnel",
                'required' => false,
            ])
            ->add('isAvailableForAppointment', CheckboxType::class, [
                'label' => "Disponible à la prise de rendez-vous - optionnel",
                'required' => false,
            ])
            ->add('jpgPicture', FileType::class, [
                'label' => 'Image du produit en jpg - optionnel',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de respecter le format .jpg',
                    ])
                ],
            ])
            ->add('webpPicture', FileType::class, [
                'label' => 'Image du produit en webp - optionnel',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de respecter le format .webp',
                    ])
                ],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie - obligatoire',
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
