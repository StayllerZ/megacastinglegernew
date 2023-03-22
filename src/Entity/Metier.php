<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetierRepository::class)]
#[ORM\Table(name: "Metier")]
class Metier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'metiers')]
    #[ORM\JoinColumn(name: 'IdentifiantDomaineMetier', referencedColumnName: 'Identifiant', nullable: false)]
    private ?DomaineMetier $domaineMetier = null;

    #[ORM\ManyToMany(targetEntity: Conseil::class, inversedBy: 'metiers')]
    #[ORM\JoinTable(name: 'MetierConseil')]
    #[ORM\JoinColumn(name: 'IdentifiantMetier', referencedColumnName: 'Identifiant')]
    #[ORM\InverseJoinColumn(name: 'IdentifiantConseil', referencedColumnName: 'Identifiant')]
    private Collection $conseils;

    #[ORM\OneToMany(mappedBy: 'metier', targetEntity: FicheMetier::class)]
    private Collection $fichesMetiers;

    #[ORM\OneToMany(mappedBy: 'metier', targetEntity: Offre::class)]
    private Collection $offres;

    public function __construct()
    {
        $this->conseils = new ArrayCollection();
        $this->fichesMetiers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDomaineMetier(): ?DomaineMetier
    {
        return $this->domaineMetier;
    }

    public function setDomaineMetier(?DomaineMetier $domaineMetier): self
    {
        $this->domaineMetier = $domaineMetier;

        return $this;
    }

    /**
     * @return Collection<int, Conseil>
     */
    public function getConseils(): Collection
    {
        return $this->conseils;
    }

    public function addConseil(Conseil $conseil): self
    {
        if (!$this->conseils->contains($conseil)) {
            $this->conseils->add($conseil);
        }

        return $this;
    }

    public function removeConseil(Conseil $conseil): self
    {
        $this->conseils->removeElement($conseil);

        return $this;
    }

    /**
     * @return Collection<int, FicheMetier>
     */
    public function getFichesMetiers(): Collection
    {
        return $this->fichesMetiers;
    }

    public function addFichesMetier(FicheMetier $fichesMetier): self
    {
        if (!$this->fichesMetiers->contains($fichesMetier)) {
            $this->fichesMetiers->add($fichesMetier);
            $fichesMetier->setMetier($this);
        }

        return $this;
    }

    public function removeFichesMetier(FicheMetier $fichesMetier): self
    {
        if ($this->fichesMetiers->removeElement($fichesMetier)) {
            // set the owning side to null (unless already changed)
            if ($fichesMetier->getMetier() === $this) {
                $fichesMetier->setMetier(null);
            }
        }

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
            $offre->setMetier($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getMetier() === $this) {
                $offre->setMetier(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }
}
