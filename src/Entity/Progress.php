<?php

namespace App\Entity;

use App\Repository\ProgressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressRepository::class)]
class Progress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lecon')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'progress')]
    private ?Lecon $lecon = null;

    #[ORM\ManyToOne(inversedBy: 'progress')]
    private ?Formation $formation = null;

    #[ORM\Column]
    private ?bool $leconValidated = null;

    #[ORM\Column]
    private ?bool $formationValidated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLecon(): ?Lecon
    {
        return $this->lecon;
    }

    public function setLecon(?Lecon $lecon): static
    {
        $this->lecon = $lecon;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function isLeconValidated(): ?bool
    {
        return $this->leconValidated;
    }

    public function setLeconValidated(bool $leconValidated): static
    {
        $this->leconValidated = $leconValidated;

        return $this;
    }

    public function isFormationValidated(): ?bool
    {
        return $this->formationValidated;
    }

    public function setFormationValidated(bool $formationValidated): static
    {
        $this->formationValidated = $formationValidated;

        return $this;
    }
}
