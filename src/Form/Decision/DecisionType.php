<?php

namespace App\Form\Decision;

use App\Entity\Decision;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => 'Titre'])
            ->add('content', CKEditorType::class, ['label' => 'Détails'])
            ->add('utility', CKEditorType::class, ['label' => 'Objectifs'])
            ->add('context', CKEditorType::class, ['label' => 'Contexte actuel'])
            ->add('benefits', CKEditorType::class, ['label' => 'Bénéfices'])
            ->add('inconvenients', CKEditorType::class, ['label' => 'Risques potentiels'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
