<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez remplir le champ')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Vous avez saisi {{ value }} caractères, cet élément doit contenir au maximum {{ limit }} caractères',
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez remplir le champ')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Vous avez saisi {{ value }} caractères, cet élément doit contenir au maximum {{ limit }} caractères',
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez remplir le champ')]
    #[Assert\Email(
        message: 'L\'adresse mail renseignée {{ value }} n\'est pas une adresse mail valide'
    )]
    private ?string $mail = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez remplir le champ')]
    #[Assert\Length(
        min: 50,
        max: 500,
        minMessage: 'Votre message est  beaucoup trop court, il doit etre superieur a {{ limit }}',
        maxMessage: 'Vous avez saisi {{ value }} caractères, cet élément doit contenir au maximum {{ limit }} caractères',
    )]
    private ?string $message = null;

    

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
