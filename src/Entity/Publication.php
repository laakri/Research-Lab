<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateP = null;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    private ?Project $projet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $titre): static
    {
        $this->title = $titre;

        return $this;
    }

    public function getDateP(): ?\DateTimeInterface
    {
        return $this->dateP;
    }

    public function setDateP(\DateTimeInterface $dateP): static
    {
        $this->dateP = $dateP;

        return $this;
    }

    public function getProjet(): ?project
    {
        return $this->projet;
    }

    public function setProjet(?project $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

 
}
