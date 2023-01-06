<?php

namespace App\Entity;

use App\Repository\ContributorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContributorRepository::class)]
class Contributor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contributors')]
    private ?Employee $employee = null;

    #[ORM\ManyToOne(inversedBy: 'contributors')]
    private ?Decision $decision = null;

    #[ORM\ManyToOne(inversedBy: 'contributors')]
    private ?Implication $implication = null;

    #[ORM\OneToMany(mappedBy: 'contributor', targetEntity: Contribution::class)]
    private Collection $contributions;

    public function __construct()
    {
        $this->contributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDecision(): ?Decision
    {
        return $this->decision;
    }

    public function setDecision(?Decision $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    public function getImplication(): ?Implication
    {
        return $this->implication;
    }

    public function setImplication(?Implication $implication): self
    {
        $this->implication = $implication;

        return $this;
    }

    /**
     * @return Collection<int, Contribution>
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): self
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions->add($contribution);
            $contribution->setContributor($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): self
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getContributor() === $this) {
                $contribution->setContributor(null);
            }
        }

        return $this;
    }
}
