<?php

namespace App\Entity;

use App\Repository\MembresRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MembresRepository::class)]
class Membres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_membre = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Regex(
        pattern: '/^[a-z]+$/i',
        htmlPattern: '^[a-zA-Z]+$',
        message: 'Le nom doit contenir uniquement des lettres'
    )]
    #[Assert\Length(
        min: 2,
        minMessage: '2 caractères minimum',
    )]
    private ?string $nom_membre = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le login est obligatoire')]
    private ?string $login_membre = null;

    public function getIdMembre(): ?int
    {
        return $this->id_membre;
    }

    public function getNomMembre(): ?string
    {
        return $this->nom_membre;
    }

    public function setNomMembre(string $nom_membre): static
    {
        $this->nom_membre = $nom_membre;

        return $this;
    }

    public function getLoginMembre(): ?string
    {
        return $this->login_membre;
    }

    public function setLoginMembre(string $login_membre): static
    {
        $this->login_membre = $login_membre;

        return $this;
    }
}
