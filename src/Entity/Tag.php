<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // @ORM\Column(type: 'string', length: 255)
    private $name;


    // @ORM\OneToMany(mappedBy: 'tag', targetEntity: Post::class, orphanRemoval: true)
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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

    /**
     * @return Collection|Advertisement[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
