<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: 'App\Repository\ArtistRepository')]
#[ORM\Table(name: 'artists')]
class Artist
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: Types::INTEGER)]
  private ?int $id = null;

  #[ORM\Column(type: 'string', length: 255)]
  private $img;

  #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
  private string $email;
  #[ORM\Column(type: Types::STRING, length: 100)]
  private string $name;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  private ?string $biography = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
  private \DateTimeInterface $createdAt;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP", "onUpdate" => "CURRENT_TIMESTAMP"])]
  private \DateTimeInterface $updatedAt;

  #[ORM\OneToMany(mappedBy: "artist", targetEntity: Artwork::class)]
  private Collection $artworks;

  public function __construct()
  {
    $this->createdAt = new \DateTime();
    $this->updatedAt = new \DateTime();
    $this->artworks = new ArrayCollection();
  }

  // Getters and Setters for other properties



  #[ORM\Column(type: "string", length: 15, nullable: true)]
  private ?string $phone = null;

  public function getPhone(): ?string
  {
    return $this->phone;
  }

  public function setPhone(?string $phone): self
  {
    $this->phone = $phone;

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
  public function getId(): ?int
  {
    return $this->id;
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

  public function getName(): string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;
    return $this;
  }

  public function getBiography(): ?string
  {
    return $this->biography;
  }

  public function setBiography(?string $biography): self
  {
    $this->biography = $biography;
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

  public function getArtworks(): Collection
  {
    return $this->artworks;
  }
}
