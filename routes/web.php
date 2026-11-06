<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::get('/', fn() => view('pages.home'))->name('home');

// Guest only
Route::middleware('web')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
});

// App Pages (Proteksi dilakukan di protect.js & API middleware)
Route::get('/home', fn() => view('pages.home'))->name('home');
Route::get('/chatbot', fn() => view('pages.chatbot'))->name('chatbot');
Route::get('/project', fn() => view('pages.project'))->name('project');
Route::get('/project/{id}', function ($id) {
    return view('pages.project_detail', ['id' => $id]);
})->name('project.detail');
Route::get('/profile', fn() => view('pages.profile'))->name('profile');

// NEW: AI Landing Page Studio (Lovable-Style)
Route::get('/landing-page', fn() => view('pages.landing_page_studio'))->name('landing-page.studio');

// NEW: Admin Dashboard (Khusus Role Admin)
Route::get('/admin', fn() => view('pages.admin'))->name('admin');

// NEW: Public Auto-Hosting URL (Terbuka untuk umum / pelanggan UMKM)
Route::get('/site/{slug}', [LandingPageController::class, 'publicSite'])->name('site.public');
