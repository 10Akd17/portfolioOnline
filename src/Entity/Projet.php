<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomProjet;

        /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoProjet;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateProjet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getPhotoProjet(): ?string
    {
        return $this->photoProjet;
    }

    public function setPhotoProjet(string $photoProjet): self
    {
        $this->photoProjet = $photoProjet;

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

    public function getDateProjet(): ?\DateTimeInterface
    {
        return $this->dateProjet;
    }

    public function setDateProjet(\DateTimeInterface $dateProjet): self
    {
        $this->dateProjet = $dateProjet;

        return $this;
    }
}
