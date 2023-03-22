<?php

namespace App\Entity;

use App\Repository\CiviliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CiviliteRepository::class)]
#[ORM\Table(name: "Civilite")]
class Civilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'civilites')]
    #[ORM\JoinTable(name: 'CiviliteOffre')]
    #[ORM\JoinColumn(name: 'IdentifiantCivilite', referencedColumnName: 'Identifiant')]
    #[ORM\InverseJoinColumn(name: 'IdentifiantOffre', referencedColumnName: 'Identifiant')]
    private Collection $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        $this->offres->removeElement($offre);

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }
}
