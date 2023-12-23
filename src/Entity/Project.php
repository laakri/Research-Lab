<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $publications = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $researcherId = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublications(): ?string
    {
        return $this->publications;
    }

    public function setPublications(?string $publications): self
    {
        $this->publications = $publications;

        return $this;
    }

    public function getResearcherId(): ?int
    {
        return $this->researcherId;
    }

    public function setResearcherId(?int $researcherId): self
    {
        $this->researcherId = $researcherId;

        return $this;
    }
}
