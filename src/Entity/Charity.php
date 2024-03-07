<?php

namespace App\Entity;

use App\Repository\CharityRepository;
use DateTime;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Double;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\Validator\Constraints\Date;


#[ORM\Entity(repositoryClass: CharityRepository::class)]
class Charity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;




    #[ORM\Column(length: 255)]
    private ?string $name_of_charity;

    #[ORM\Column]
    private ?float $amount_donated;

    #[ORM\Column]
    private ?float $total_of_donation;

    #[ORM\Column]
    private ?DateTime $last_date;



    #[ORM\Column(length: 255)]
    private ?string $picture = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmountDonated(): ?float
    {
        return $this->amount_donated;
    }

    public function setAmountDonated(float $amount_donated): static
    {
        $this->amount_donated = $amount_donated;
        return $this;
    }

    public function getTotalOfDonation(): ?float
    {
        return $this->total_of_donation;
    }

    public function setTotalOfDonation(float $total_of_donation): static
    {
        $this->total_of_donation = $total_of_donation;
        return $this;
    }

    public function getLastDate(): ?DateTime
    {
        return $this->last_date;
    }

    public function setLastDate(DateTime $last_date): static
    {
        $this->last_date = $last_date;
        return $this;
    }

    public function getNameOfCharity(): ?string
    {
        return $this->name_of_charity;
    }

    public function setNameOfCharity(string $name_of_charity): static
    {
        $this->name_of_charity = $name_of_charity;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;
        return $this;
    }
    public function __toString()
    {
        return $this->name_of_charity;
    }
}
