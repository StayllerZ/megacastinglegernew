<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
#[ORM\Table(name: "Offre")]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebutCasting = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFinCasting = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    #[ORM\Column]
    private ?int $ageMinimum = null;

    #[ORM\Column]
    private ?int $ageMaximum = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(name: 'IdentifiantTypeContrat', referencedColumnName: 'Identifiant', nullable: false)]
    private ?TypeContrat $typeContrat = null;

    #[ORM\ManyToMany(targetEntity: Civilite::class, mappedBy: 'offres')]
    private Collection $civilites;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(name: 'IdentifiantClient', referencedColumnName: 'Identifiant', nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(name: 'IdentifiantMetier', referencedColumnName: 'Identifiant', nullable: false)]
    private ?Metier $metier = null;

    #[ORM\ManyToMany(targetEntity: PartenaireDiffusion::class, mappedBy: 'offres')]
    private Collection $partenaireDiffusions;

    public function __construct()
    {
        $this->civilites = new ArrayCollection();
        $this->partenaireDiffusions = new ArrayCollection();
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

    public function getDateDebutCasting(): ?\DateTimeInterface
    {
        return $this->dateDebutCasting;
    }

    public function setDateDebutCasting(\DateTimeInterface $dateDebutCasting): self
    {
        $this->dateDebutCasting = $dateDebutCasting;

        return $this;
    }

    public function getDateFinCasting(): ?\DateTimeInterface
    {
        return $this->dateFinCasting;
    }

    public function setDateFinCasting(\DateTimeInterface $dateFinCasting): self
    {
        $this->dateFinCasting = $dateFinCasting;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getAgeMinimum(): ?int
    {
        return $this->ageMinimum;
    }

    public function setAgeMinimum(int $ageMinimum): self
    {
        $this->ageMinimum = $ageMinimum;

        return $this;
    }

    public function getAgeMaximum(): ?int
    {
        return $this->ageMaximum;
    }

    public function setAgeMaximum(int $ageMaximum): self
    {
        $this->ageMaximum = $ageMaximum;

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

    public function getTypeContrat(): ?TypeContrat
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(?TypeContrat $typeContrat): self
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    /**
     * @return Collection<int, Civilite>
     */
    public function getCivilites(): Collection
    {
        return $this->civilites;
    }

    public function addCivilite(Civilite $civilite): self
    {
        if (!$this->civilites->contains($civilite)) {
            $this->civilites->add($civilite);
            $civilite->addOffre($this);
        }

        return $this;
    }

    public function removeCivilite(Civilite $civilite): self
    {
        if ($this->civilites->removeElement($civilite)) {
            $civilite->removeOffre($this);
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getMetier(): ?Metier
    {
        return $this->metier;
    }

    public function setMetier(?Metier $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    /**
     * @return Collection<int, PartenaireDiffusion>
     */
    public function getPartenaireDiffusions(): Collection
    {
        return $this->partenaireDiffusions;
    }

    public function addPartenaireDiffusion(PartenaireDiffusion $partenaireDiffusion): self
    {
        if (!$this->partenaireDiffusions->contains($partenaireDiffusion)) {
            $this->partenaireDiffusions->add($partenaireDiffusion);
            $partenaireDiffusion->addOffre($this);
        }

        return $this;
    }

    public function removePartenaireDiffusion(PartenaireDiffusion $partenaireDiffusion): self
    {
        if ($this->partenaireDiffusions->removeElement($partenaireDiffusion)) {
            $partenaireDiffusion->removeOffre($this);
        }

        return $this;
    }
}
