<?php

namespace App\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use App\Form\DecisionType;
use App\Form\DecisionStep2Type;
use App\Form\DecisionStep3Type;

class CreateVehicleFlow extends FormFlow
{
    protected function loadStepsConfig(): array
    {
            return [
                    [
                            'label' => 'title', 'content', 'utility', 'context', 'benefits', 'inconvenients',
                            'form_type' => DecisionType::class,
                    ],
                    [
                            'label' => '',
                            'form_type' => DecisionStep2Type::class,
                            'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                                 return $estimatedCurrentStepNumber > 1 && !$flow->getFormData()->canHaveEngine();
                            },
                    ],
                    [
                            'label' => 'date',
                    ],
            ];
    }
}
