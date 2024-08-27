<?php

namespace App\Entity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class User implements UserInterface,PasswordAuthenticatedUserInterface{


    public function __construct(
        private ?string $role = null,
        #[Email()]
        #[NotBlank()]
        private ?string $email = null,
        #[NotBlank()]
        private ?string $mdp =null,
        private ?int $id = null
    ) {}

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self{
        $this->email = $email;
        return $this;
    }

    #[Ignore] // N'envoie pas le mot de pass en get ! 
    public function getMdp(): ?string {
        return $this->mdp
        ;
    }

    public function setMdp(?string $mdp): self{
        $this->mdp = $mdp;
        return $this;
    }
    public function getRole(): ?string {
        return $this->role;
    }

    public function setRole(?string $role): self{
        $this->role = $role;
        return $this;
    }
    public function getRoles(): array{
        return [$this->role];
    }
    public function eraseCredentials(): void{}
    public function getUserIdentifier(): string{
        return $this->email;
    }
    public function getPassword(): string|null{
        return $this->mdp;
    }
}