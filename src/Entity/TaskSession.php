<?php

namespace App\Entity;

use App\Repository\TaskSessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskSessionRepository::class)]
class TaskSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'taskSessions')]
    private ?Task $Task = null;

    #[ORM\ManyToOne(inversedBy: 'taskSessions')]
    private ?Session $Session = null;

    #[ORM\Column]
    private ?bool $isTaskCompleted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->Task;
    }

    public function setTask(?Task $Task): static
    {
        $this->Task = $Task;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->Session;
    }

    public function setSession(?Session $Session): static
    {
        $this->Session = $Session;

        return $this;
    }

    public function isIsTaskCompleted(): ?bool
    {
        return $this->isTaskCompleted;
    }

    public function setIsTaskCompleted(bool $isTaskCompleted): static
    {
        $this->isTaskCompleted = $isTaskCompleted;

        return $this;
    }
}
