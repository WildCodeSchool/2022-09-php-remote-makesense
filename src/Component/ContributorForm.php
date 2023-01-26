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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Traversable;

#[AsLiveComponent('contributor_form')]
class ContributorForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(writable: true, fieldName: 'decisionField')]
    public ?Decision $decision = null;

    #[LiveProp(writable: true)]
    public ?string $search = null;

    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly ImplicationRepository $implicationRepos,
        private readonly DecisionRepository $decisionRepository
    ) {
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DecisionContributorsType::class, $this->decision);
    }

    #[LiveAction]
    public function addNewContributor(#[LiveArg] ?int $employeeId): void
    {
        if ($employeeId) {
            $employee = $this->employeeRepository->findOneBy(['id' => $employeeId]);

            $contributor = new Contributor();
            $contributor->setEmployee($employee);
            $contributor->setImplication($this->implicationRepos->find(1));

            $this->decision->addContributor($contributor);
            $this->decisionRepository->save($this->decision, true);
            $this->search = null;

            $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->enableMagicCall()
                ->getPropertyAccessor();
            $propertyAccessor->setValue($this->decision, 'contributors', [$contributor]);
            $this->addCollectionItem($propertyAccessor, '[contributors]');
//            return $this->redirectToRoute('app_decision_contributors_edit', ['id' => $this->decision->getId()]);
        }
    }

    #[LiveAction]
    public function removeContributor(#[LiveArg] int $contributorIndex): void
    {
        unset($this->formValues['contributors'][$contributorIndex]);
    }

    #[LiveAction]
    public function save(DecisionRepository $decisionRepository): Response
    {
        // shortcut to submit the form with form values
        // if any validation fails, an exception is thrown automatically
        // and the component will be re-rendered with the form errors
        $this->submitForm();

        /** @var Decision $decision*/
        $decision = $this->getFormInstance()->getData();
        $decisionRepository->save($decision, true);

        $this->addFlash('success', 'Décision sauvegardée !');

        return $this->redirectToRoute('app_decision_show', [
            'id' => $this->decision->getId(),
        ]);
    }

    public function getResults(): array
    {
        return $this->search ? $this->employeeRepository->search($this->search) : [];
    }
}
