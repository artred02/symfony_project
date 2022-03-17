<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemFormType extends AbstractType
{
    //ici, on crée le formulaire de création d'un item avec un builder
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category')
            ->add('name')
            ->add('brand')
            ->add('price')
        ;
    }

    //Ici, les options ont été générées par défaut et je n'ai rien ajouter
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
