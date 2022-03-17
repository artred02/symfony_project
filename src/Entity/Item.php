<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    //L'entité item, une entité qui permet de stocker les items rajoutés par un admin

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $category;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $brand;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Owns::class, orphanRemoval: true)]
    private $owns;


    public function __construct()
    {
        $this->owner = new ArrayCollection();
        $this->owns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }


    //relation avec l'entité owns pour mettre en relation l'id d'un item avec celui d'un user
    /**
     * @return Collection|Owns[]
     */
    public function getOwns(): Collection
    {
        return $this->owns;
    }

    public function addOwn(Owns $own): self
    {
        if (!$this->owns->contains($own)) {
            $this->owns[] = $own;
            $own->setItem($this);
        }

        return $this;
    }

    public function removeOwn(Owns $own): self
    {
        if ($this->owns->removeElement($own)) {
            // set the owning side to null (unless already changed)
            if ($own->getItem() === $this) {
                $own->setItem(null);
            }
        }

        return $this;
    }

}
