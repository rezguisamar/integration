<?php

namespace App\Entity;

use App\Repository\EpreuveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
class Epreuve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_p = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quizid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateP(): ?\DateTimeInterface
    {
        return $this->date_p;
    }

    public function setDateP(\DateTimeInterface $date_p): static
    {
        $this->date_p = $date_p;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getQuizid(): ?Quiz
    {
        return $this->quizid;
    }

    public function setQuizid(?Quiz $quizid): static
    {
        $this->quizid = $quizid;

        return $this;
    }
}
