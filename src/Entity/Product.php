<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo; 
use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank (message:"veuillez saisir le nom du produit ")]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    
    #[ORM\Column(length: 255)]
    private ?string $productname = null;

    #[Assert\NotBlank (message:"veuillez entrer la quantité du produit ")]
    #[Assert\Length(min:1)]
    #[Assert\Length(max:20)]

    #[ORM\Column]
    private ?int $productquantity = null;



    #[Assert\NotBlank (message:"veuillez entrer la taille du produit ")]
   
    #[Assert\Length(max:20)]

    #[ORM\Column(length: 255)]
    private ?string $productsize = null;




    #[Assert\GreaterThan(0)]
    #[Assert\Type(type: "float")]
    #[Assert\NotBlank (message:"veuillez saisir le prix du produit ")]
    #[Assert\Length(max:21)]
    #[ORM\Column]
    private ?float $productprice = null;


    #[Assert\NotBlank (message:"veuillez saisir une description du produit")]
    #[Assert\Length(min:10)]
    #[Assert\Length(max:150)]

    

    #[ORM\Column(length: 255)]
    private ?string $productdescription = null;

    #[Assert\NotBlank (message:"veuillez saisir une description du produit")]
    #[Assert\Length(min:10)]
    #[Assert\Length(max:150)]

    #[ORM\Column(length: 255)]
    private ?string $productimg = null;



    #[Assert\NotBlank (message:"veuillez préciser la disponibilité du produit ")]

    #[Assert\Length(max:20)]

    #[ORM\Column(length: 255)]
    private ?string $productdisponibility = 'disponible';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductname(): ?string
    {
        return $this->productname;
    }

    public function setProductname(string $productname): static
    {
        $this->productname = $productname;

        return $this;
    }

    public function getProductquantity(): ?int
    {
        return $this->productquantity;
    }

    public function setProductquantity(int $productquantity): static
    {
        $this->productquantity = $productquantity;

        return $this;
    }

    public function getProductsize(): ?string
    {
        return $this->productsize;
    }

    public function setProductsize(string $productsize): static
    {
        $this->productsize = $productsize;

        return $this;
    }

    public function getProductprice(): ?float
    {
        return $this->productprice;
    }

    public function setProductprice(float $productprice): static
    {
        $this->productprice = $productprice;

        return $this;
    }

    public function getProductdescription(): ?string
    {
        return $this->productdescription;
    }

    public function setProductdescription(string $productdescription): static
    {
        $this->productdescription = $productdescription;

        return $this;
    }

    public function getProductdisponibility(): ?string
    {
        return $this->productdisponibility;
    }

    public function setProductdisponibility(string $productdisponibility): static
    {
        $this->productdisponibility = $productdisponibility;

        return $this;
    }

    public function getProductimg(): ?string
    {
        return $this->productimg;
    }

    public function setProductimg(string $productimg): static
    {
        $this->productimg = $productimg;

        return $this;
    }


}
