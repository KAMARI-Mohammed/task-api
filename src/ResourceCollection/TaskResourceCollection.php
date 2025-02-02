<?php

namespace App\Resource;

# Gère une collection de ressources Task.
class TaskResourceCollection
{
    public function __construct(private array $tasks) {}
    
    public function toArray(): array
    {
        dump($this->tasks);
        return array_map(fn($task) => (new TaskResource($task))->toArray(), $this->tasks);
    }
}