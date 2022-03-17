<?php

namespace App\Entity;

use App\Repository\OwnsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnsRepository::class)]
class Owns
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'owns')]
    #[ORM\JoinColumn(nullable: false)]
    private $item;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'owns')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'integer')]
    private $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
