<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JoueurRepository")
 */
class Joueur
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personnage", mappedBy="joueur")
     */
    private $Personnage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MyTable", mappedBy="joueurs")
     */
    private $Tables;

    public function __construct()
    {
        $this->Personnage = new ArrayCollection();
        $this->Tables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Personnage[]
     */
    public function getPersonnage(): Collection
    {
        return $this->Personnage;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->Personnage->contains($personnage)) {
            $this->Personnage[] = $personnage;
            $personnage->setJoueur($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->Personnage->contains($personnage)) {
            $this->Personnage->removeElement($personnage);
            // set the owning side to null (unless already changed)
            if ($personnage->getJoueur() === $this) {
                $personnage->setJoueur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MyTable[]
     */
    public function getTables(): Collection
    {
        return $this->Tables;
    }

    public function addTable(MyTable $table): self
    {
        if (!$this->Tables->contains($table)) {
            $this->Tables[] = $table;
            $table->addJoueur($this);
        }

        return $this;
    }

    public function removeTable(MyTable $table): self
    {
        if ($this->Tables->contains($table)) {
            $this->Tables->removeElement($table);
            $table->removeJoueur($this);
        }

        return $this;
    }
    public function __toString()
    {
        return 'any string';
    }
}
