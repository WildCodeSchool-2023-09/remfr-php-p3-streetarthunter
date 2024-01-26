<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
class Artwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?float $longitude = null;

    #[ORM\Column(length: 255)]
    private ?float $latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\OneToOne(mappedBy: 'artwork', cascade: ['persist', 'remove'])]
    private ?Point $point = null;

    #[ORM\ManyToOne(inversedBy: 'artwork')]
    private ?Artist $artist = null;

    #[ORM\OneToMany(mappedBy: 'artwork', targetEntity: Image::class)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPoint(): ?Point
    {
        return $this->point;
    }

    public function setPoint(?Point $point): static
    {
        // unset the owning side of the relation if necessary
        if ($point === null && $this->point !== null) {
            $this->point->setArtwork(null);
        }

        // set the owning side of the relation if necessary
        if ($point !== null && $point->getArtwork() !== $this) {
            $point->setArtwork($this);
        }

        $this->point = $point;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setArtwork($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArtwork() === $this) {
                $image->setArtwork(null);
            }
        }

        return $this;
    }
}
