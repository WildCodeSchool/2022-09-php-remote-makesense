<?php

namespace App\Form;

use App\Entity\Contribution;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ContributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('type', ContributionType::class, [
//            'default_value' => 'conflit'])
//            ->add('date', DateType::class, [
//                'input'  => 'datetime_immutable'])
//            ->add('date', DateType::class, [
//                'default_value'  => new \DateTime(),
//                ])
                ->add('content', CKEditorType::class)
//            ->add('decision', null, [
//                'default_value' => function($decision) {
//                return $decision->getId();
//                }
//            ])
//            ->add('contributor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contribution::class,
        ]);
    }
}
