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
    private ?string $longitude = null;

    #[ORM\Column(length: 255)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'artworks')]
    private Collection $user;

    #[ORM\OneToOne(mappedBy: 'artwork', cascade: ['persist', 'remove'])]
    private ?Point $point = null;

    #[ORM\OneToOne(mappedBy: 'artwork', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'artwork')]
    private ?Artist $artist = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
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

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        // unset the owning side of the relation if necessary
        if ($image === null && $this->image !== null) {
            $this->image->setArtwork(null);
        }

        // set the owning side of the relation if necessary
        if ($image !== null && $image->getArtwork() !== $this) {
            $image->setArtwork($this);
        }

        $this->image = $image;

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
}
