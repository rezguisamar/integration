<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter valid Title')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Quiz Title should be at least {{ limit }} characters', maxMessage: 'Your name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Quiz Title should contain only alphabetic letters'
    )]
    private ?string $titre = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?int $note = null;
    #[ORM\Column]
    private ?int $nbrq = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    private ?Cour $courid = null;

    #[ORM\OneToMany(mappedBy: 'quizid', targetEntity: Question::class)]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

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
    public function getNbrq(): ?int
    {
        return $this->nbrq;
    }

    public function setNbrq(int $nbrq): static
    {
        $this->nbrq = $nbrq;

        return $this;
    }

    public function getCourid(): ?Cour
    {
        return $this->courid;
    }

    public function setCourid(?Cour $courid): static
    {
        $this->courid = $courid;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuizid($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuizid() === $this) {
                $question->setQuizid(null);
            }
        }

        return $this;
    }
}
