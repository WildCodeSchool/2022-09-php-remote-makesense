<?php

namespace App\Component;

use App\Entity\Contributor;
use App\Entity\Decision;
use App\Form\Decision\DecisionContributorsType;
use App\Repository\DecisionRepository;
use App\Repository\EmployeeRepository;
use App\Repository\ImplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent('contributor_form')]
class ContributorForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    public function __construct(
        private EmployeeRepository $employeeRepository,
        private ImplicationRepository $implicationRepository,
        private DecisionRepository $decisionRepository
    ) {

    }

    #[LiveProp]
    public ?Decision $decision = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DecisionContributorsType::class, $this->decision);
    }

    #[LiveAction]
    public function addNewContributor(#[LiveArg] int $id = 5)
    {
        $employee = $this->employeeRepository->find($id);
        $contributor = new Contributor();
        $contributor->setEmployee($employee);
        $contributor->setImplication($this->implicationRepository->find(1));
        $this->decision->addContributor($contributor);
        $this->decisionRepository->save($this->decision, true);
        $this->formValues['contributors'][] = ['firstname' => $employee->getFirstname()];
    }
}


