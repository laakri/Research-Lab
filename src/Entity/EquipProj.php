<?php

namespace App\Entity;

use App\Repository\EquipProjRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipProjRepository::class)]
class EquipProj
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $projID = null;

    #[ORM\Column]
    private ?int $equipID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjID(): ?int
    {
        return $this->projID;
    }

    public function setProjID(?int $projID): static
    {
        $this->projID = $projID;

        return $this;
    }

    public function getEquipID(): ?int
    {
        return $this->equipID;
    }

    public function setEquipID(int $equipID): static
    {
        $this->equipID = $equipID;

        return $this;
    }
}
