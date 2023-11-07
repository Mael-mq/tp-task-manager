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

    #[ORM\ManyToMany(targetEntity: Session::class, inversedBy: 'tasks')]
    private Collection $TaskSession;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->TaskSession = new ArrayCollection();
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

    /**
     * @return Collection<int, Session>
     */
    public function getTaskSession(): Collection
    {
        return $this->TaskSession;
    }

    public function addTaskSession(Session $taskSession): static
    {
        if (!$this->TaskSession->contains($taskSession)) {
            $this->TaskSession->add($taskSession);
        }

        return $this;
    }

    public function removeTaskSession(Session $taskSession): static
    {
        $this->TaskSession->removeElement($taskSession);

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
}
