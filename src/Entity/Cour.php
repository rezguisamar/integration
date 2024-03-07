<?php

namespace App\Entity;

use App\Repository\CourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CourRepository::class)]
class Cour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter valid Title')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Course Title should be at least {{ limit }} characters', maxMessage: 'Your name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Course Title should contain only alphabetic letters'
    )]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter valid Description')]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\OneToMany(mappedBy: 'courid', targetEntity: Quiz::class)]
    private Collection $quizzes;

    #[ORM\Column(length: 255)]
    private ?string $pdfpath = null;

    public function __construct()
    {
        $this->quizzes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): static
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes->add($quiz);
            $quiz->setCourid($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): static
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getCourid() === $this) {
                $quiz->setCourid(null);
            }
        }

        return $this;
    }

    public function getPdfpath(): ?string
    {
        return $this->pdfpath;
    }

    public function setPdfpath(string $pdfpath): static
    {
        $this->pdfpath = $pdfpath;

        return $this;
    }
}
