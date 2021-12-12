<?php

namespace App\Form;

use App\Form\Model\RentalFilmModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentFilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user')
            ->add('film')
            ->add('count')
            ->add('days')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => RentalFilmModel::class,
            // Configure your form options here
            'csrf_protection' => false
        ]);
    }
}
