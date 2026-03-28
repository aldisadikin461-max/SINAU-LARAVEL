<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\Guru\EbookController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\QuestionController;
use App\Http\Controllers\Guru\TaskController;
use App\Http\Controllers\Siswa\SiswaController;
use Illuminate\Support\Facades\Route;

// ── Landing Page ──────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Auth (Breeze) ─────────────────────────────────────────────────
require __DIR__ . '/auth.php';

// ── Redirect setelah login berdasarkan role ───────────────────────
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru'  => redirect()->route('guru.dashboard'),
        default => redirect()->route('siswa.dashboard'),
    };
})->name('dashboard');

// ── ADMIN ─────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');

    // Kelola User
    Route::get('/users',               [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit',   [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}',        [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}',     [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Beasiswa
    Route::resource('scholarships', ScholarshipController::class);

    // WhatsApp
    Route::get('/whatsapp',                    [WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::post('/whatsapp/link/{user}',       [WhatsAppController::class, 'linkSiswa'])->name('whatsapp.link');
    Route::post('/whatsapp/blast',             [WhatsAppController::class, 'blast'])->name('whatsapp.blast');
});

// ── GURU ──────────────────────────────────────────────────────────
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {

    Route::get('/dashboard',    [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/progres',      [GuruController::class, 'pregresSiswa'])->name('progres');

    Route::resource('ebooks',    EbookController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('tasks',     TaskController::class);
});

// ── SISWA ─────────────────────────────────────────────────────────
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {

    Route::get('/dashboard',   [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/latihan',     [SiswaController::class, 'latihanSoal'])->name('latihan');
    Route::post('/jawab',      [SiswaController::class, 'jawabSoal'])->name('jawab');
    Route::get('/leaderboard', [SiswaController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/beasiswa',    [SiswaController::class, 'beasiswa'])->name('beasiswa');
    Route::post('/beasiswa/bookmark', [SiswaController::class, 'toggleBookmark'])->name('beasiswa.bookmark');
    Route::get('/study-plan',  [SiswaController::class, 'studyPlan'])->name('study-plan');
    Route::post('/study-plan', [SiswaController::class, 'storeStudyPlan'])->name('study-plan.store');
    Route::patch('/study-plan/{plan}', [SiswaController::class, 'updateStudyPlan'])->name('study-plan.update');
    Route::delete('/study-plan/{plan}', [SiswaController::class, 'destroyStudyPlan'])->name('study-plan.destroy');
    Route::get('/forum',       [SiswaController::class, 'forum'])->name('forum');
    Route::post('/forum',      [SiswaController::class, 'storeForum'])->name('forum.store');
    Route::post('/forum/{forum}/reply', [SiswaController::class, 'storeReply'])->name('forum.reply');
    Route::get('/riwayat',     [SiswaController::class, 'riwayat'])->name('riwayat');
    Route::get('/pomodoro',    [SiswaController::class, 'pomodoro'])->name('pomodoro');
    Route::post('/notif/read', [SiswaController::class, 'markNotifRead'])->name('notif.read');
});
