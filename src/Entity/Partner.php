<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $municipalitypartner = null;

    #[ORM\Column(length: 255)]
    private ?string $privatepartner = null;

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'partners')]
    private Collection $artist;

    public function __construct()
    {
        $this->artist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMunicipalitypartner(): ?string
    {
        return $this->municipalitypartner;
    }

    public function setMunicipalitypartner(string $municipalitypartner): static
    {
        $this->municipalitypartner = $municipalitypartner;

        return $this;
    }

    public function getPrivatepartner(): ?string
    {
        return $this->privatepartner;
    }

    public function setPrivatepartner(string $privatepartner): static
    {
        $this->privatepartner = $privatepartner;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getArtist(): Collection
    {
        return $this->artist;
    }

    public function addArtist(Artist $artist): static
    {
        if (!$this->artist->contains($artist)) {
            $this->artist->add($artist);
        }

        return $this;
    }

    public function removeArtist(Artist $artist): static
    {
        $this->artist->removeElement($artist);

        return $this;
    }
}
