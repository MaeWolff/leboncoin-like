<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * ORM\Table(name: '`post`')
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue 
     * @ORM\Column(type="integer")
     */
    private $id;

    // @ORM\Column(type: 'datetime')]
    private $date;

    // @ORM\Column(type: 'string', length: 255)]
    private $title;

    // @ORM\Column(type: 'string', length: 5000)]
    private $description;

    // @ORM\Column(type: 'array', nullable: true)]
    private $images = [];

    // @ORM\Column(type: 'float')]
    private $price;

    // @ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')
    private $author;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(array $images): self
    {
        $this->images = $images;
 
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}