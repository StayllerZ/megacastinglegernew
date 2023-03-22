<?php

namespace App\Entity;

use App\Repository\PartenaireDiffusionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartenaireDiffusionRepository::class)]
#[ORM\Table(name: "PartenaireDiffusion")]
class PartenaireDiffusion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'partenaireDiffusions')]
    #[ORM\JoinTable(name: 'PartenaireDiffusionOffre')]
    #[ORM\JoinColumn(name: 'IdentifiantPartenaireDiffusion', referencedColumnName: 'Identifiant')]
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
        return $this->nom;
    }
}
