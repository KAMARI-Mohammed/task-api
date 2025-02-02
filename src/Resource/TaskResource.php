<?php

namespace App\Resource;

use App\Entity\Task;

# couche pour Transformer une entité Task en un format JSON.
class TaskResource
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    
    public function toArray(): array
    {
        return [
            'id' => $this->task->getId(),
            'title' => $this->task->getTitle(),
            'description' => $this->task->getDescription(),
            'status' => $this->task->getStatus(),
            'created_at' => $this->task->getCreatedAt()?->format('Y-m-d H:i:s')
        ];
    }
}