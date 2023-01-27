<?php

namespace App\Form;

use App\Entity\Decision;
use App\Entity\Timeline;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimelineBisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => Timeline::class,
                'choice_label' => 'name',
                ])
            ->add('started_at', EntityType::class, [
                'class' => Timeline::class,
                'choice_label' => 'started_at',
                ])
            ->add('ended_at', EntityType::class, [
                'class' => Timeline::class,
                'choice_label' => 'ended_at',
                ])
        ;
    }

//->add('Etape', ChoiceType::class, [
//'Prise de décision',
//'Fin dépose des avis' => null,
//'Première décision validée' => true,
//'Date de fin pour conflits',
//'Décision définitive',


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Timeline::class,
        ]);
    }
}
