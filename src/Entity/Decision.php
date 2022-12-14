<?php

namespace App\Entity;

use App\Repository\DecisionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DecisionRepository::class)]
class Decision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez indiquer un titre')]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $utility = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $context = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $benefits = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $inconvenients = null;

    #[ORM\OneToMany(mappedBy: 'decision', targetEntity: Contributor::class)]
    private Collection $contributors;

    public function __construct()
    {
        $this->contributors = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUtility(): ?string
    {
        return $this->utility;
    }

    public function setUtility(?string $utility): self
    {
        $this->utility = $utility;

        return $this;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(?string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getBenefits(): ?string
    {
        return $this->benefits;
    }

    public function setBenefits(?string $benefits): self
    {
        $this->benefits = $benefits;

        return $this;
    }

    public function getInconvenients(): ?string
    {
        return $this->inconvenients;
    }

    public function setInconvenients(?string $inconvenients): self
    {
        $this->inconvenients = $inconvenients;

        return $this;
    }

    /**
     * @return Collection<int, Contributor>
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(Contributor $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors->add($contributor);
            $contributor->setDecision($this);
        }

        return $this;
    }

    public function removeContributor(Contributor $contributor): self
    {
        if ($this->contributors->removeElement($contributor)) {
            // set the owning side to null (unless already changed)
            if ($contributor->getDecision() === $this) {
                $contributor->setDecision(null);
            }
        }

        return $this;
    }
}
