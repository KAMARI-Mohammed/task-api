<?php

namespace App\Controller;

use App\Service\TaskService;
use App\Resource\TaskResource;
use App\Entity\Task;
use App\Resource\TaskResourceCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

# Cette couche est une partie fondamentale de notre architecture, c’est le point d'entrée de l'application pour toutes les requêtes HTTP (GET, POST, PUT, DELETE,etc.)
class TaskController extends AbstractController
{
    public function __construct(private TaskService $taskService) {}

    #[Route('/tasks', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getTasks();
        $data = array_map(fn($task) => (new TaskResource($task))->toArray(), $tasks);        
        return new JsonResponse($data, JsonResponse::HTTP_OK);

    }

    #[Route('/tasks', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->toArray());
        return $this->json(new TaskResource($task));
    }

    #[Route('/tasks/{id}', methods: ['PUT'])]
    public function update(Task $task, Request $request): JsonResponse
    {
        $updatedTask = $this->taskService->updateTask($task, $request->toArray());
        return $this->json(new TaskResource($updatedTask));
    }

    #[Route('/tasks/{id}', methods: ['DELETE'])]
    public function destroy(Task $task): JsonResponse
    {
        $this->taskService->deleteTask($task);
        return $this->json(['message' => 'Task deleted successfully']);
    }
}