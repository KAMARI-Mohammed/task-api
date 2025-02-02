<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

# couche service permet de centraliser la logique métier
class TaskService
{
    private TaskRepository $taskRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $entityManager)
    {
        $this->taskRepository = $taskRepository;
        $this->entityManager = $entityManager;
    }

    public function createTask(array $data): Task
    {
        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setStatus($data['status']);
        
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        return $task;
    }

    public function getTasks(): array
    {
        $tasks = $this->taskRepository->findAllTasks();
        return $tasks;
    }

    public function getTasksByStatus(string $status): array
    {
        return $this->taskRepository->findByStatus($status);
    }

    public function getRecentTasks(int $limit = 10): array
    {
        return $this->taskRepository->findRecentTasks($limit);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->setTitle($data['title'] ?? $task->getTitle());
        $task->setDescription($data['description'] ?? $task->getDescription());
        $task->setStatus($data['status'] ?? $task->getStatus());
        
        $this->entityManager->flush();
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
