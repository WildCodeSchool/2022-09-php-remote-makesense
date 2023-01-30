<?php

namespace App\Component;

use App\Entity\Contributor;
use App\Entity\Decision;
use App\Repository\ContributorRepository;
use App\Repository\DecisionRepository;
use App\Repository\EmployeeRepository;
use App\Repository\ImplicationRepository;
use App\Services\ContributorMailerService;
use App\Services\MailerService;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('contributor_form')]
class ContributorForm extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?Decision $decision = null;

    #[LiveProp(writable: true)]
    public ?string $search = null;

    public bool $hasChanged = false;

    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly ImplicationRepository $implicationRepos,
        private readonly DecisionRepository $decisionRepository,
        private readonly ContributorRepository $contributorRepos,
        private readonly ContributorMailerService $mailer
    ) {
    }
    #[LiveAction]
    public function addNewContributor(#[LiveArg] ?int $employeeId): void
    {
        if ($employeeId) {
            $employee = $this->employeeRepository->findOneBy(['id' => $employeeId]);

            $contributor = new Contributor();
            $contributor->setEmployee($employee);
            $contributor->setImplication($this->implicationRepos->findOneBy(['terms' => 'impacted']));

            $this->decision->addContributor($contributor);
            $this->decisionRepository->save($this->decision, true);
            $this->search = null;
            $this->hasChanged = true;
            $emailTo = $contributor->getEmployee()->getEmail();
            $decision = $this->decision;
            $this->mailer->sendEmail($emailTo, $contributor, $decision);
        }
    }

    public function getContributors(): Collection
    {
        return $this->decision->getContributors();
    }

    #[LiveAction]
    public function removeContributor(#[LiveArg] int $contributorId): void
    {
        $contributor = $this->contributorRepos->find($contributorId);
        if ($contributor) {
            $this->decision->removeContributor($contributor);
            $this->decisionRepository->save($this->decision, true);
            $this->hasChanged = true;
        }
    }

    public function getResults(): array
    {
        return $this->search ? $this->employeeRepository->search($this->search) : [];
    }

    public function getImplications(): array
    {
        return $this->implicationRepos->findAll();
    }

    #[LiveAction]
    public function changeContributorImplication(#[LiveArg] int $contributorId, #[LiveArg] int $implicationId): void
    {
        $implication = $this->implicationRepos->find($implicationId);
        $contributor = $this->contributorRepos->find($contributorId);
        $contributor->setImplication($implication);
        $this->contributorRepos->save($contributor, true);
        $this->hasChanged = true;
    }
}
