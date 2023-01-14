<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyDecisionSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'Prise de décision commencée' => 'Prise de décision commencée',
                    'Donner son avis' => 'Deadline pour donner son avis',
                    'Prendre sa première décision' => 'Première décision prise',
                    'Entrer un conflit' => 'Deadline pour entrer en conflit',
                    'Décision définitive' => 'Décision définitive',
                    'Décision terminée' => 'Décision terminée',
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Decision::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
