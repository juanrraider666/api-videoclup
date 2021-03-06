<?php

namespace App\Form;

use App\Entity\Film;
use App\Form\Model\FilmDataModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilmDataModel::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return ''; // TODO: Change the autogenerated stub
    }
}
