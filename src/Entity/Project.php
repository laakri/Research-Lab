<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 35, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $researcherId = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'principalProjects')]
    private ?User $principalResearcher = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'projects')]
    private Collection $researchers;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Publication::class, cascade: ['persist', 'remove'])]
    private Collection $publications;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->researchers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getResearcherId(): ?int
    {
        return $this->researcherId;
    }

    public function setResearcherId(?int $researcherId): static
    {
        $this->researcherId = $researcherId;

        return $this;
    }

    public function getPrincipalResearcher(): ?User
    {
        return $this->principalResearcher;
    }

    public function setPrincipalResearcher(?User $principalResearcher): static
    {
        $this->principalResearcher = $principalResearcher;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getResearchers(): Collection
    {
        return $this->researchers;
    }

    public function addResearcher(User $researcher): static
    {
        if (!$this->researchers->contains($researcher)) {
            $this->researchers->add($researcher);
            // You might want to add some additional logic here, like setting roles for the researcher
        }

        return $this;
    }

    public function removeResearcher(User $researcher): static
    {
        $this->researchers->removeElement($researcher);

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setProjet($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getProjet() === $this) {
                $publication->setProjet(null);
            }
        }

        return $this;
    }
}
