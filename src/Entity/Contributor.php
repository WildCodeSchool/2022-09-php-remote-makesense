<?php

namespace App\Entity;

use App\Repository\ContributorRepository;
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
}
