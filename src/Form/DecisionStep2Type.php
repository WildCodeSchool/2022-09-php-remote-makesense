<?php

namespace App\Form;

use App\Entity\Decision;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DecisionStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
              ->add('employees', EntityType::class, [
                  'class' => Employee::class,
                  'choice_label' => function(Employee $employee) {
                      return
                          $employee->getLastName() . " " .
                          $employee->getFirstName();
                  },
                  'multiple' => true,
                  'expanded' => true,
                  'by_reference' => false,
                  'query_builder' => function(EmployeeRepository $employeeRepository) {
                      return $employeeRepository->createQueryBuilder('e')
                          ->orderBy('e.lastname', 'ASC');}
                ]);
    }

//    public function getBlockPrefix(): string
//    {
//        return 'DecisionStep2';
//    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
