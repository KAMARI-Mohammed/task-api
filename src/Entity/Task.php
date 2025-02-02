<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(length: 50)]
    private string $status;

    #[ORM\Column(type: "datetime_immutable")]
    private ?DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function getCreatedAT():?DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
