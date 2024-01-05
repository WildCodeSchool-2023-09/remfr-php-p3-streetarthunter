<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà lié à un compte')]
#[UniqueEntity(fields: ['username'], message: 'Ce pseudo existe déjà!')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /* lastname */
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom saisi {{ value }} est trop long et 
    ne devrait pas dépasser {{ limit }} caractères')]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;
    /* firstname */
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    #[Assert\Length(max: 255, maxMessage: 'Le prénom saisi {{ value }} est trop long et
     ne devrait pas dépasser {{ limit }} caractères')]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;
    /* username */
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    #[Assert\Length(max: 255, maxMessage: 'Le pseudo saisi {{ value }} est trop long et 
    ne devrait pas dépasser {{ limit }} caractères')]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;
    /* mail */
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    #[Assert\Email(
        message: 'L\'email saisi {{ value }} n\'est pas valide.',
    )]
    #[Assert\Regex('([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.
    [0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})')]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /* password */
    /**
     * @var string The hashed password
     */
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    #[Assert\Length(
        min: 8,
        minMessage: 'Ton mot de passe doit contenir {{ limit }} caractères minimum',
        max: 255,
        maxMessage: 'La catégorie saisie {{ value }} est trop longue, 
        elle ne devrait pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Artwork::class, mappedBy: 'user')]
    private Collection $artworks;

    public function __construct()
    {
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworks(): Collection
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): static
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks->add($artwork);
            $artwork->addUser($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): static
    {
        if ($this->artworks->removeElement($artwork)) {
            $artwork->removeUser($this);
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
