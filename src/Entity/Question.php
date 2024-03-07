<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Please enter valid Question')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Question should be at least {{ limit }} characters', maxMessage: 'Your name cannot be longer than {{ limit }} characters')]
    private ?string $question = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Please enter valid Respone')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Response should be at least {{ limit }} characters', maxMessage: 'Your name cannot be longer than {{ limit }} characters')]
    private ?string $reponse = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Quiz $quizid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

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
