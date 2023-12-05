<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $startAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $isCompleted = null;

    #[ORM\OneToMany(mappedBy: 'Session', targetEntity: TaskSession::class)]
    private Collection $taskSessions;

    public function __construct()
    {
        $this->taskSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTime
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTime $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

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
            $taskSession->setSession($this);
        }

        return $this;
    }

    public function removeTaskSession(TaskSession $taskSession): static
    {
        if ($this->taskSessions->removeElement($taskSession)) {
            // set the owning side to null (unless already changed)
            if ($taskSession->getSession() === $this) {
                $taskSession->setSession(null);
            }
        }

        return $this;
    }
}
