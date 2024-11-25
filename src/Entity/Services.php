<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Gardes>
     */
    #[ORM\OneToMany(targetEntity: Gardes::class, mappedBy: 'service')]
    private Collection $gardes;

    public function __construct()
    {
        $this->gardes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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
            $garde->setService($this);
        }

        return $this;
    }

    public function removeGarde(Gardes $garde): static
    {
        if ($this->gardes->removeElement($garde)) {
            // set the owning side to null (unless already changed)
            if ($garde->getService() === $this) {
                $garde->setService(null);
            }
        }

        return $this;
    }
}
