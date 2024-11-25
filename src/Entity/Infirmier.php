<?php

namespace App\Entity;

use App\Repository\InfirmierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfirmierRepository::class)]
class Infirmier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Gardes>
     */
    #[ORM\OneToMany(targetEntity: Gardes::class, mappedBy: 'infirmier')]
    private Collection $gardes;

    public function __construct()
    {
        $this->gardes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Gardes>
     */
    public function getGardes(): Collection
    {
        return $this->gardes;
    }

    public function addGarde(Gardes $garde): static
    {
        if (!$this->gardes->contains($garde)) {
            $this->gardes->add($garde);
            $garde->setInfirmier($this);
        }

        return $this;
    }

    public function removeGarde(Gardes $garde): static
    {
        if ($this->gardes->removeElement($garde)) {
            // set the owning side to null (unless already changed)
            if ($garde->getInfirmier() === $this) {
                $garde->setInfirmier(null);
            }
        }

        return $this;
    }
}
