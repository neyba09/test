<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskSingleCollection;
use App\Services\TaskService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService  $taskService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = $this->taskService->getTasks(Auth::id(), $request->query('per_page', 10));

        return TaskResource::collection($tasks);
    }

    public function show(int $id)
    {
        $task = $this->taskService->getTaskById(Auth::id(), $id);

        return new TaskSingleCollection(collect([$task]));
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated(), Auth::user());

        return response()->json(
            new TaskResource($task),
            Response::HTTP_CREATED,
            ['Location' => route('tasks.show', $task->id)]
        );
    }

    public function destroy(int $id): Response
    {
        $this->taskService->deleteTask(Auth::id(), $id);

        return response()->noContent();
    }

    public function update(TaskUpdateRequest $request, int $id): JsonResponse
    {
        $task = $this->taskService->updateTask(Auth::id(), $id, $request->validated());

        return response()->json(new TaskResource($task), Response::HTTP_OK);
    }
}
