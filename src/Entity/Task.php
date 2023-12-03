<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'Task', targetEntity: TaskSession::class)]
    private Collection $taskSessions;

    public function __construct()
    {
        $this->taskSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, TaskSession>
     */
    public function getTaskSessions(): Collection
    {
        return $this->taskSessions;
    }

    public function addTaskSession(TaskSession $taskSession): static
    {
        if (!$this->taskSessions->contains($taskSession)) {
            $this->taskSessions->add($taskSession);
            $taskSession->setTask($this);
        }

        return $this;
    }

    public function removeTaskSession(TaskSession $taskSession): static
    {
        if ($this->taskSessions->removeElement($taskSession)) {
            // set the owning side to null (unless already changed)
            if ($taskSession->getTask() === $this) {
                $taskSession->setTask(null);
            }
        }

        return $this;
    }
}
