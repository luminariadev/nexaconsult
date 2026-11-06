<?php

namespace App\Http\Controllers;

use App\Services\AiService;
use App\Services\AuthService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    protected ProjectService $projectService;
    protected AuthService $auth;
    protected AiService $ai;

    public function __construct(ProjectService $projectService, AuthService $auth, AiService $ai)
    {
        $this->projectService = $projectService;
        $this->auth = $auth;
        $this->ai = $ai;
    }

    /**
     * MAIN ENDPOINT — CHATBOT
     */
    public function consult(Request $req)
    {
        $req->validate([
            'prompt'  => 'required|string',
            'context' => 'nullable|string'
        ]);

        $prompt  = trim($req->prompt);
        $context = $req->context;

        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        // JIKA USER MENJAWAB "YA" (atau variasinya) → BUAT PROJECT ROADMAP
        if (preg_match('/^(ya|iya|yes|buatkan|buatkan project|oke|ok|setuju|gas)$/i', $prompt)) {
            $businessIdea = $context ?: $prompt;
            return $this->createProject($businessIdea, $userId);
        }

        // KONSULTASI NORMAL
        $answer = $this->ai->consultOnly($prompt, $context);

        return response()->json([
            'status'             => 'consult',
            'message'            => $answer,
            'needs_confirmation' => true,
            'context'            => $prompt
        ]);
    }

    /**
     * MEMBUAT PROJECT BARU DARI HASIL KONSULTASI AI
     */
    protected function createProject(string $userPrompt, string $userId)
    {
        $structured = $this->ai->generateProject($userPrompt);

        $projectData = [
            'user_id'     => (string) $userId,
            'user_prompt' => $userPrompt,
            'name'        => $structured['title'] ?? 'Proyek Bisnis Baru',
            'description' => $structured['summary'] ?? '',
            'status'      => 'active',
            'tasks'       => array_map(fn($t) => [
                'task'       => is_array($t) ? ($t['task'] ?? '') : (string)$t,
                'done'       => false,
                'created_at' => now()->toISOString()
            ], $structured['tasks'] ?? [])
        ];

        $created = $this->projectService->create($projectData);

        return response()->json([
            'status'  => 'created',
            'message' => '🎉 Selamat! Roadmap proyek bisnis Anda berhasil dibuat oleh AI.',
            'project' => $created
        ]);
    }
}
