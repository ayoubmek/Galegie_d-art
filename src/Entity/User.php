<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: 'App\Repository\UserRepository')]
#[ORM\Table(name: 'users')]
class User implements UserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: Types::INTEGER)]
  private ?int $id = null;

  #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
  private string $username;

  #[ORM\Column(type: 'string', length: 255)]
  private $img;

  #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
  private string $email;

  #[ORM\Column(type: Types::STRING, length: 255)]
  private string $password;

  #[ORM\Column(type: Types::STRING, columnDefinition: "ENUM('CLIENT', 'ADMIN', 'SUPER_ADMIN')", options: ["default" => 'CLIENT'])]
  private string $role = 'CLIENT';

  #[ORM\Column(type: "string", length: 15, nullable: true)]
  private ?string $phone = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
  private \DateTimeInterface $createdAt;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP", "onUpdate" => "CURRENT_TIMESTAMP"])]
  private \DateTimeInterface $updatedAt;

  public function __construct()
  {
    $this->createdAt = new \DateTime();
    $this->updatedAt = new \DateTime();
  }

  // Getters and setters

  public function getPhone(): ?string
  {
    return $this->phone;
  }

  public function setPhone(?string $phone): self
  {
    $this->phone = $phone;

    return $this;
  }
  public function getId(): ?int
  {
      return $this->id;
  }
  public function getUsername(): string
  {
    return $this->username;
  }



  public function setUsername(string $username): self
  {
    $this->username = $username;
    return $this;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }
  public function getImg(): ?string
  {
    return $this->img;
  }

  public function setImg(string $img): self
  {
    $this->img = $img;
    return $this;
  }


  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;
    return $this;
  }

  public function getRole(): string
  {
    return $this->role;
  }

  public function setRole(string $role): self
  {
    $this->role = $role;
    return $this;
  }

  public function getCreatedAt(): \DateTimeInterface
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeInterface $createdAt): self
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  public function getUpdatedAt(): \DateTimeInterface
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeInterface $updatedAt): self
  {
    $this->updatedAt = $updatedAt;
    return $this;
  }

  // Symfony UserInterface methods
  public function getRoles(): array
  {
    return [$this->role];
  }

  public function getSalt(): ?string
  {
    return null; // bcrypt or argon2i do not require salt
  }

  public function eraseCredentials(): void
  {
    // If you store any temporary sensitive data on the user, clear it here
  }
}
