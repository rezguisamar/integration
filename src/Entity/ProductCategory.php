<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;




#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
class ProductCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank (message:"veuillez saisir le nom du produit ")]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]

    #[ORM\Column(length: 255)]
    private ?string $categoryname = null;



    #[Assert\NotBlank (message:"veuillez saisir le nom du produit ")]
    
    #[ORM\Column(length: 255)]
    private ?string $categoryimage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryname(): ?string
    {
        return $this->categoryname;
    }

    public function setCategoryname(string $categoryname): static
    {
        $this->categoryname = $categoryname;

        return $this;
    }

    public function getCategoryimage(): ?string
    {
        return $this->categoryimage;
    }

    public function setCategoryimage(string $categoryimage): static
    {
        $this->categoryimage = $categoryimage;

        return $this;
    }
}
