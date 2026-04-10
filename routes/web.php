<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAlumniController;
use App\Http\Controllers\Admin\KemitraanController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\Guru\EbookController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\QuestionController;
use App\Http\Controllers\Guru\TaskController;
use App\Http\Controllers\Guru\QuizPacketController;
use App\Http\Controllers\Guru\RasionalisasiGuruController;
use App\Http\Controllers\Siswa\AlumniController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\Siswa\QuizAttemptController;
use App\Http\Controllers\Siswa\RasionalisasiController;
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
        'siswa' => redirect()->route('siswa.dashboard'),
        default => redirect()->route('siswa.dashboard'),
    };
})->name('dashboard');

// ══════════════════════════════════════════════════════════════════
//  ADMIN
// ══════════════════════════════════════════════════════════════════
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');

    // Kelola User
    Route::get('/users',             [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create',      [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users',            [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}',      [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}',   [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Beasiswa
    Route::resource('scholarships', ScholarshipController::class);

    // WhatsApp
    Route::get('/whatsapp',              [WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::post('/whatsapp/link/{user}', [WhatsAppController::class, 'linkSiswa'])->name('whatsapp.link');
    Route::post('/whatsapp/blast',       [WhatsAppController::class, 'blast'])->name('whatsapp.blast');

    // Alumni Kuliah
    Route::get('/alumni',              [AdminAlumniController::class, 'index'])->name('alumni.index');
    Route::post('/alumni/import',      [AdminAlumniController::class, 'import'])->name('alumni.import');
    Route::get('/alumni/template',     [AdminAlumniController::class, 'template'])->name('alumni.template');
    Route::delete('/alumni-bulk',      [AdminAlumniController::class, 'destroyByTahun'])->name('alumni.destroy-tahun');
    Route::delete('/alumni/{alumni}',  [AdminAlumniController::class, 'destroy'])->name('alumni.destroy');

    // Kemitraan
    Route::resource('kemitraan', KemitraanController::class);
});

// ══════════════════════════════════════════════════════════════════
//  GURU
// ══════════════════════════════════════════════════════════════════
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/progres',   [GuruController::class, 'pregresSiswa'])->name('progres');

    Route::resource('ebooks',    EbookController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('tasks',     TaskController::class);

    // ── Quiz Packet Guru ──
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/',       [QuizPacketController::class, 'index'])->name('index');
        // ✅ Import — WAJIB di atas /{quiz} agar tidak terbaca sebagai parameter
        Route::get('/import',  [QuizPacketController::class, 'importForm'])->name('import.form');
        Route::post('/import', [QuizPacketController::class, 'importExcel'])->name('import');

        Route::get('/create', [QuizPacketController::class, 'create'])->name('create');
        Route::post('/',      [QuizPacketController::class, 'store'])->name('store');

        Route::get('/{quiz}',      [QuizPacketController::class, 'show'])->name('show');
        Route::get('/{quiz}/edit', [QuizPacketController::class, 'edit'])->name('edit');
        Route::put('/{quiz}',      [QuizPacketController::class, 'update'])->name('update');
        Route::delete('/{quiz}',   [QuizPacketController::class, 'destroy'])->name('destroy');

        // Soal dalam paket
        Route::get('/{quiz}/question/create',          [QuizPacketController::class, 'createQuestion'])->name('question.create');
        Route::post('/{quiz}/question',                [QuizPacketController::class, 'storeQuestion'])->name('question.store');
        Route::get('/{quiz}/question/{question}/edit', [QuizPacketController::class, 'editQuestion'])->name('question.edit');
        Route::put('/{quiz}/question/{question}',      [QuizPacketController::class, 'updateQuestion'])->name('question.update');
        Route::delete('/{quiz}/question/{question}',   [QuizPacketController::class, 'destroyQuestion'])->name('question.destroy');
    });

    // Rasionalisasi Guru
    Route::prefix('rasionalisasi')->name('rasionalisasi.')->group(function () {
        Route::get('/',     [RasionalisasiGuruController::class, 'index'])->name('index');
        Route::get('/{id}', [RasionalisasiGuruController::class, 'show'])->name('show');
    });
});

// ══════════════════════════════════════════════════════════════════
//  SISWA
// ══════════════════════════════════════════════════════════════════
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/dashboard',   [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat',     [SiswaController::class, 'riwayat'])->name('riwayat');
    Route::get('/latihan',     [SiswaController::class, 'latihanSoal'])->name('latihan');
    Route::post('/jawab',      [SiswaController::class, 'jawabSoal'])->name('jawab');
    Route::post('/streak/activate', [SiswaController::class, 'activateStreak'])->name('streak.activate');
    Route::post('/streak/recover',  [SiswaController::class, 'recoverStreak'])->name('streak.recover');
    Route::get('/leaderboard', [SiswaController::class, 'leaderboard'])->name('leaderboard');

    // ── Quiz Siswa ──
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/',                    [QuizAttemptController::class, 'index'])->name('index');
        Route::get('/riwayat',             [QuizAttemptController::class, 'riwayat'])->name('riwayat');
        Route::get('/hasil/{attempt}',     [QuizAttemptController::class, 'hasil'])->name('hasil');
        Route::get('/{packet}',            [QuizAttemptController::class, 'show'])->name('show');
        Route::post('/{packet}',           [QuizAttemptController::class, 'submit'])->name('submit');
    });

    // Rasionalisasi Siswa
    Route::prefix('rasionalisasi')->name('rasionalisasi.')->group(function () {
        Route::get('/',           [RasionalisasiController::class, 'index'])->name('index');
        Route::get('/kuliah',     [RasionalisasiController::class, 'formKuliah'])->name('kuliah');
        Route::get('/kerja',      [RasionalisasiController::class, 'formKerja'])->name('kerja');
        Route::post('/kuliah',    [RasionalisasiController::class, 'prosesKuliah'])->name('kuliah.proses');
        Route::post('/kerja',     [RasionalisasiController::class, 'prosesKerja'])->name('kerja.proses');
        Route::get('/hasil/{id}', [RasionalisasiController::class, 'hasil'])->name('hasil');
        Route::get('/riwayat',    [RasionalisasiController::class, 'riwayat'])->name('riwayat');
        Route::get('/bandingkan', [RasionalisasiController::class, 'bandingkan'])->name('bandingkan');
        Route::post('/bookmark',  [RasionalisasiController::class, 'bookmark'])->name('bookmark');
        Route::delete('/{id}',    [RasionalisasiController::class, 'destroy'])->name('destroy');
    });

    // Beasiswa
    Route::get('/beasiswa',           [SiswaController::class, 'beasiswa'])->name('beasiswa');
    Route::post('/beasiswa/bookmark', [SiswaController::class, 'toggleBookmark'])->name('beasiswa.bookmark');

    // Study Plan
    Route::get('/study-plan',           [SiswaController::class, 'studyPlan'])->name('study-plan');
    Route::post('/study-plan',          [SiswaController::class, 'storeStudyPlan'])->name('study-plan.store');
    Route::patch('/study-plan/{plan}',  [SiswaController::class, 'updateStudyPlan'])->name('study-plan.update');
    Route::delete('/study-plan/{plan}', [SiswaController::class, 'destroyStudyPlan'])->name('study-plan.destroy');

    // Forum
    Route::get('/forum',                [SiswaController::class, 'forum'])->name('forum');
    Route::post('/forum',               [SiswaController::class, 'storeForum'])->name('forum.store');
    Route::post('/forum/{forum}/reply', [SiswaController::class, 'storeReply'])->name('forum.reply');

    // Pomodoro
    Route::get('/pomodoro',    [SiswaController::class, 'pomodoro'])->name('pomodoro');
    Route::post('/notif/read', [SiswaController::class, 'markNotifRead'])->name('notif.read');

    // Alumni
    Route::get('/alumni',          [AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/alumni/kuliah',   [AlumniController::class, 'kuliah'])->name('alumni.kuliah');
    Route::get('/alumni/kemitraan',[AlumniController::class, 'kemitraan'])->name('alumni.kemitraan');
});