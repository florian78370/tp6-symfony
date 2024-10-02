<?php

namespace App\Entity;

use App\Repository\MorceauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MorceauRepository::class)]
class Morceau
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $durée = null;

    #[ORM\ManyToOne(inversedBy: 'morceaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    #[ORM\Column]
    private ?int $piste = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $Id): static
    {
        $this->id = $Id;

        return $this;
    }
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDurée(): ?string
    {
        return $this->durée;
    }

    public function setDurée(string $durée): static
    {
        $this->durée = $durée;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }

    public function getPiste(): ?int
    {
        return $this->piste;
    }

    public function setPiste(int $piste): static
    {
        $this->piste = $piste;

        return $this;
    }
}
