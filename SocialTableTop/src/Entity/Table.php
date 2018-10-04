<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableRepository")
 */
class Table
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mj;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Joueur", inversedBy="Tables")
     */
    private $joueurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personnage", mappedBy="TableDeJeux")
     */
    private $Personnages;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->Personnages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getMj(): ?string
    {
        return $this->Mj;
    }

    public function setMj(string $Mj): self
    {
        $this->Mj = $Mj;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection|Joueur[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): self
    {
        if ($this->joueurs->contains($joueur)) {
            $this->joueurs->removeElement($joueur);
        }

        return $this;
    }

    /**
     * @return Collection|Personnage[]
     */
    public function getPersonnages(): Collection
    {
        return $this->Personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->Personnages->contains($personnage)) {
            $this->Personnages[] = $personnage;
            $personnage->setTableDeJeux($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->Personnages->contains($personnage)) {
            $this->Personnages->removeElement($personnage);
            // set the owning side to null (unless already changed)
            if ($personnage->getTableDeJeux() === $this) {
                $personnage->setTableDeJeux(null);
            }
        }

        return $this;
    }
}
