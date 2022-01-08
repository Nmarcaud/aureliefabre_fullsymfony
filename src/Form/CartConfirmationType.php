<?php

namespace App\Form;

use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class CartConfirmationType extends AbstractType
{
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Nom complet',
                'attr' => [
                    'placeholder' => "Aurélie Fabre"
                ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Numéro et rue',
                'attr' => [
                    'placeholder' => "37 rue Aurélie Fabre"
                ]
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => "37000"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => "TOURS"
                ]
            ])
            ->setAction($this->urlGenerator->generate('purchase_confirm'))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }
}
