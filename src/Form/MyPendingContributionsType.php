<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyPendingContributionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'Filtrer par' => '',
                    'Donner mon avis' => 'Deadline pour donner son avis',
                    'Déclarer un conflit' => 'Deadline pour entrer en conflit',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }
}
