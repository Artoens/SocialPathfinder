<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnageRepository")
 */
class Personnage
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Joueur", inversedBy="Personnage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $joueur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MyTable", inversedBy="Personnages")
     */
    private $TableDeJeux;

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

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getTableDeJeux(): ?MyTable
    {
        var_dump($this->TableDeJeux->GetName());
        return $this->TableDeJeux;
    }

    public function setTableDeJeux(?MyTable $TableDeJeux): self
    {
        $this->TableDeJeux = $TableDeJeux;

        return $this;
    }
}
