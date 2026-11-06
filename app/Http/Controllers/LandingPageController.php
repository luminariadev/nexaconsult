<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LandingPageService;
use App\Services\AuthService;

class LandingPageController extends Controller
{
    protected LandingPageService $landingPageService;
    protected AuthService $auth;

    public function __construct(LandingPageService $landingPageService, AuthService $auth)
    {
        $this->landingPageService = $landingPageService;
        $this->auth = $auth;
    }

    /**
     * POST /api/landing-page/generate (Generate with AI)
     */
    public function generate(Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'title'           => 'required|string|min:3',
            'description'     => 'required|string|min:10',
            'theme_color'     => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'custom_prompt'   => 'nullable|string',
        ]);

        $html = $this->landingPageService->generateLandingPageHtml(
            $request->input('title'),
            $request->input('description'),
            $request->input('theme_color', 'indigo'),
            $request->input('whatsapp_number', '081234567890'),
            $request->input('custom_prompt')
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Landing page berhasil digenerate oleh AI!',
            'data'    => [
                'html_content' => $html
            ]
        ]);
    }

    /**
     * POST /api/landing-page/save (Save & Auto-Host)
     */
    public function save(Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'title'           => 'required|string',
            'html_content'    => 'required|string',
            'slug'            => 'nullable|string',
            'project_id'      => 'nullable|string',
            'theme_color'     => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'html_content', 'slug', 'project_id', 'theme_color', 'whatsapp_number']);
        $data['user_id'] = $userId;

        $saved = $this->landingPageService->save($data);
        $publicUrl = url('/site/' . $saved['slug']);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Landing page berhasil dipublikasikan dan live secara otomatis!',
            'data'       => $saved,
            'public_url' => $publicUrl
        ]);
    }

    /**
     * GET /api/landing-page (List User's Landing Pages)
     */
    public function index()
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $pages = $this->landingPageService->listByUser($userId);

        return response()->json([
            'status' => 'success',
            'data'   => $pages
        ]);
    }

    /**
     * GET /api/landing-page/{id}
     */
    public function show($id)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $page = $this->landingPageService->findByIdAndUser($id, $userId);
        if (!$page) {
            return response()->json(['status' => 'error', 'message' => 'Landing page tidak ditemukan.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $page,
            'public_url' => url('/site/' . $page['slug'])
        ]);
    }

    /**
     * DELETE /api/landing-page/{id}
     */
    public function destroy($id)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $deleted = $this->landingPageService->delete($id, $userId);

        return response()->json([
            'status'  => $deleted ? 'success' : 'error',
            'message' => $deleted ? 'Landing page berhasil dihapus' : 'Gagal menghapus landing page'
        ]);
    }

    /**
     * GET /site/{slug} (PUBLIC AUTO-HOSTING ROUTE - NO AUTH REQUIRED)
     */
    public function publicSite($slug)
    {
        $page = $this->landingPageService->findBySlug($slug);

        if (!$page || empty($page['html_content'])) {
            abort(404, 'Halaman landing page usaha tidak ditemukan.');
        }

        // Return raw standalone HTML
        return response($page['html_content'], 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
}
