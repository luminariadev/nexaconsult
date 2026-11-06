<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\ProjectService;
use App\Services\AiService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected ProjectService $projectService;
    protected AuthService $auth;

    public function __construct(ProjectService $projectService, AuthService $auth)
    {
        $this->projectService = $projectService;
        $this->auth = $auth;
    }

    /**
     * GET /api/projects
     */
    public function index()
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $projects = $this->projectService->findByUser($userId);

        return response()->json([
            'status' => 'success',
            'data'   => $projects
        ]);
    }

    /**
     * GET /api/projects/stats
     */
    public function stats()
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $stats = $this->projectService->getUserStats($userId);

        return response()->json([
            'status' => 'success',
            'data'   => $stats
        ]);
    }

    /**
     * GET /api/projects/{id}
     */
    public function show($id)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $project = $this->projectService->findByIdAndUser($id, $userId);

        if (!$project) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Project tidak ditemukan atau akses ditolak.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $project
        ]);
    }

    /**
     * PUT /api/projects/{id}
     */
    public function update($id, Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name'        => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:active,completed,draft'
        ]);

        $project = $this->projectService->update($id, $userId, array_filter($validated, fn($v) => !is_null($v)));

        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Gagal memperbarui project.'], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Project berhasil diperbarui',
            'data'    => $project
        ]);
    }

    /**
     * DELETE /api/projects/{id}
     */
    public function destroy($id)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $deleted = $this->projectService->delete($id, $userId);

        if (!$deleted) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Project tidak ditemukan atau bukan milik Anda.'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Project berhasil dihapus.'
        ]);
    }

    /**
     * PUT /api/projects/{id}/tasks/{index}/toggle
     */
    public function toggleTask($id, $index)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $tasks = $this->projectService->toggleTask($id, $userId, (int)$index);

        if ($tasks === null || $tasks === false) {
            return response()->json(['status' => 'error', 'message' => 'Task index atau project tidak ditemukan.'], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Status task diperbarui',
            'data'    => $tasks,
            'project' => $this->projectService->findByIdAndUser($id, $userId)
        ]);
    }

    /**
     * POST /api/projects/{id}/tasks (Add single or multiple tasks)
     */
    public function storeTask($id, Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'task'  => 'nullable|string',
            'tasks' => 'nullable|array'
        ]);

        $tasksToAdd = [];
        if ($request->has('tasks') && is_array($request->tasks)) {
            $tasksToAdd = $request->tasks;
        } elseif ($request->has('task') && trim($request->task) !== '') {
            $tasksToAdd = [$request->task];
        }

        if (empty($tasksToAdd)) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada task yang dikirim.'], 422);
        }

        $updatedTasks = $this->projectService->addTasks($id, $userId, $tasksToAdd);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task berhasil ditambahkan',
            'data'    => $updatedTasks,
            'project' => $this->projectService->findByIdAndUser($id, $userId)
        ]);
    }

    /**
     * PUT /api/projects/{id}/tasks/{index} (Edit task text)
     */
    public function updateTask($id, $index, Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate(['task' => 'required|string']);

        $updatedTasks = $this->projectService->editTask($id, $userId, (int)$index, $request->task);

        if ($updatedTasks === null || $updatedTasks === false) {
            return response()->json(['status' => 'error', 'message' => 'Task tidak ditemukan.'], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Task berhasil diubah',
            'data'    => $updatedTasks,
            'project' => $this->projectService->findByIdAndUser($id, $userId)
        ]);
    }

    /**
     * DELETE /api/projects/{id}/tasks/{index}
     */
    public function destroyTask($id, $index)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $updatedTasks = $this->projectService->deleteTask($id, $userId, (int)$index);

        if ($updatedTasks === null || $updatedTasks === false) {
            return response()->json(['status' => 'error', 'message' => 'Task tidak ditemukan.'], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Task berhasil dihapus',
            'data'    => $updatedTasks,
            'project' => $this->projectService->findByIdAndUser($id, $userId)
        ]);
    }

    /**
     * POST /api/projects/{id}/ai-expand (AI Task Suggester)
     */
    public function aiExpandTasks($id, AiService $ai)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $project = $this->projectService->findByIdAndUser($id, $userId);
        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Project tidak ditemukan.'], 404);
        }

        $newSuggestedTasks = $ai->expandProjectTasks($project['name'], $project['description'] ?? '', $project['tasks'] ?? []);
        $updatedTasks = $this->projectService->addTasks($id, $userId, $newSuggestedTasks);

        return response()->json([
            'status'  => 'success',
            'message' => 'AI berhasil menambahkan 5 task strategi baru!',
            'data'    => $updatedTasks,
            'project' => $this->projectService->findByIdAndUser($id, $userId)
        ]);
    }

    /**
     * POST /api/projects/{id}/ai-swot
     */
    public function aiSwot($id, AiService $ai)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $project = $this->projectService->findByIdAndUser($id, $userId);
        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Project tidak ditemukan.'], 404);
        }

        $swot = $ai->generateSwotAnalysis($project['name'], $project['description'] ?? '');

        return response()->json([
            'status' => 'success',
            'data'   => $swot
        ]);
    }

    /**
     * POST /api/projects/{id}/ai-pitch
     */
    public function aiPitch($id, AiService $ai)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $project = $this->projectService->findByIdAndUser($id, $userId);
        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Project tidak ditemukan.'], 404);
        }

        $pitch = $ai->generateMarketingPitch($project['name'], $project['description'] ?? '');

        return response()->json([
            'status' => 'success',
            'data'   => $pitch
        ]);
    }

    /**
     * POST /api/projects/{id}/ai-regenerate
     */
    public function aiRegenerate($id, Request $request, AiService $ai)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $project = $this->projectService->findByIdAndUser($id, $userId);
        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Project tidak ditemukan.'], 404);
        }

        $newSummary = $ai->regenerateStrategySummary(
            $project['name'],
            $project['description'] ?? '',
            $request->input('instruction')
        );

        $this->projectService->update($id, $userId, ['description' => $newSummary]);

        return response()->json([
            'status'      => 'success',
            'message'     => 'Ringkasan strategi berhasil di-regenerate oleh AI!',
            'description' => $newSummary
        ]);
    }
}
