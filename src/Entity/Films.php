<?php

namespace App\Entity;

use App\Repository\FilmsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FilmsRepository::class)]
/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Films
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', length: 255)]
    private $synopsis;

    #[ORM\Column(type: 'string', length: 255)]
    private $producteur;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'films')]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    /**
     * @Vich\UploadableField(mapping="films_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getProducteur(): ?string
    {
        return $this->producteur;
    }

    public function setProducteur(string $producteur): self
    {
        $this->producteur = $producteur;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
}
