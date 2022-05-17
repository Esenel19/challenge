<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Product::class)]
    private $categorie_id;


    public function __toString()
    {
        return $this->getTitle();
    }


    public function __construct()
    {
        $this->categorie_id = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Product>
     */
    public function getCategorieId(): Collection
    {
        return $this->categorie_id;
    }

    public function addCategorieId(Product $categorieId): self
    {
        if (!$this->categorie_id->contains($categorieId)) {
            $this->categorie_id[] = $categorieId;
            $categorieId->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorieId(Product $categorieId): self
    {
        if ($this->categorie_id->removeElement($categorieId)) {
            // set the owning side to null (unless already changed)
            if ($categorieId->getCategorie() === $this) {
                $categorieId->setCategorie(null);
            }
        }

        return $this;
    }
    

}
