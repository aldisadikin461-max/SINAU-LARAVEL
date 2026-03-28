<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Forum;
use App\Models\Quest;
use App\Models\Question;
use App\Models\Scholarship;
use App\Models\Streak;
use App\Models\Tryout;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────────
        $admin = User::create([
            'name'       => 'Admin Sinau',
            'email'      => 'admin@smkn1pwt.sch.id',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'phone'      => '081234567890',
            'total_poin' => 0,
            'level'      => 1,
        ]);

        $guru1 = User::create([
            'name'     => 'Pak Budi Santoso',
            'email'    => 'budi.guru@smkn1pwt.sch.id',
            'password' => Hash::make('password'),
            'role'     => 'guru',
            'jurusan'  => 'RPL',
            'phone'    => '081298765432',
        ]);

        $guru2 = User::create([
            'name'     => 'Bu Dewi Rahayu',
            'email'    => 'dewi.guru@smkn1pwt.sch.id',
            'password' => Hash::make('password'),
            'role'     => 'guru',
            'jurusan'  => 'TKJ',
            'phone'    => '081311223344',
        ]);

        $jurusanList = ['RPL', 'TKJ', 'MM', 'AK', 'PM'];
        $kelasList   = ['X', 'XI', 'XII'];
        $siswaData   = [
            ['name' => 'Andi Pratama',    'email' => 'andi@siswa.smkn1pwt.sch.id',    'phone' => '085711111111'],
            ['name' => 'Bela Safitri',    'email' => 'bela@siswa.smkn1pwt.sch.id',    'phone' => '085722222222'],
            ['name' => 'Candra Wijaya',   'email' => 'candra@siswa.smkn1pwt.sch.id',  'phone' => '085733333333'],
            ['name' => 'Dina Marlina',    'email' => 'dina@siswa.smkn1pwt.sch.id',    'phone' => '085744444444'],
            ['name' => 'Eko Setiawan',    'email' => 'eko@siswa.smkn1pwt.sch.id',     'phone' => '085755555555'],
            ['name' => 'Fani Kurniawan',  'email' => 'fani@siswa.smkn1pwt.sch.id',    'phone' => '085766666666'],
            ['name' => 'Galih Prasetyo',  'email' => 'galih@siswa.smkn1pwt.sch.id',   'phone' => '085777777777'],
            ['name' => 'Hani Oktaviani',  'email' => 'hani@siswa.smkn1pwt.sch.id',    'phone' => '085788888888'],
            ['name' => 'Irfan Maulana',   'email' => 'irfan@siswa.smkn1pwt.sch.id',   'phone' => '085799999999'],
            ['name' => 'Joko Susilo',     'email' => 'joko@siswa.smkn1pwt.sch.id',    'phone' => '085700000001'],
            ['name' => 'Kiki Amalia',     'email' => 'kiki@siswa.smkn1pwt.sch.id',    'phone' => '085700000002'],
            ['name' => 'Lina Permata',    'email' => 'lina@siswa.smkn1pwt.sch.id',    'phone' => '085700000003'],
            ['name' => 'Miko Pradipta',   'email' => 'miko@siswa.smkn1pwt.sch.id',    'phone' => '085700000004'],
            ['name' => 'Nina Astuti',     'email' => 'nina@siswa.smkn1pwt.sch.id',    'phone' => '085700000005'],
            ['name' => 'Omar Faruq',      'email' => 'omar@siswa.smkn1pwt.sch.id',    'phone' => '085700000006'],
            ['name' => 'Putri Handayani', 'email' => 'putri@siswa.smkn1pwt.sch.id',   'phone' => '085700000007'],
            ['name' => 'Rafi Alfarizi',   'email' => 'rafi@siswa.smkn1pwt.sch.id',    'phone' => '085700000008'],
            ['name' => 'Sari Dewanti',    'email' => 'sari@siswa.smkn1pwt.sch.id',    'phone' => '085700000009'],
            ['name' => 'Tono Wibowo',     'email' => 'tono@siswa.smkn1pwt.sch.id',    'phone' => '085700000010'],
            ['name' => 'Umar Hakim',      'email' => 'umar@siswa.smkn1pwt.sch.id',    'phone' => '085700000011'],
        ];

        $siswaList = [];
        foreach ($siswaData as $i => $data) {
            $siswaList[] = User::create(array_merge($data, [
                'password'   => Hash::make('password'),
                'role'       => 'siswa',
                'jurusan'    => $jurusanList[$i % count($jurusanList)],
                'kelas'      => $kelasList[$i % count($kelasList)],
                'total_poin' => rand(0, 500),
                'level'      => rand(1, 6),
            ]));
        }

        // ── Streaks untuk beberapa siswa ─────────────────────────
        $streakValues = [30, 14, 7, 21, 3, 0, 60, 5, 1, 10];
        foreach ($siswaList as $i => $siswa) {
            $count = $streakValues[$i % count($streakValues)];
            Streak::create([
                'user_id'          => $siswa->id,
                'streak_count'     => $count,
                'last_active_date' => $count > 0 ? Carbon::today()->subDay(rand(0, 1)) : null,
                'longest_streak'   => $count + rand(0, 5),
            ]);
        }

        // ── Categories ────────────────────────────────────────────
        $categories = [
            ['nama_kategori' => 'Pemrograman Web',        'tipe' => 'mapel_jurusan'],
            ['nama_kategori' => 'Basis Data',             'tipe' => 'mapel_jurusan'],
            ['nama_kategori' => 'Jaringan Komputer',      'tipe' => 'mapel_jurusan'],
            ['nama_kategori' => 'Matematika',             'tipe' => 'mapel_umum'],
            ['nama_kategori' => 'Bahasa Inggris',         'tipe' => 'mapel_umum'],
        ];
        $cats = [];
        foreach ($categories as $cat) {
            $cats[] = Category::create($cat);
        }

        // ── Ebooks ────────────────────────────────────────────────
        $ebookData = [
            ['judul' => 'Dasar-Dasar Laravel 11',           'penulis' => 'Pak Budi',    'cat' => 0],
            ['judul' => 'HTML & CSS untuk Pemula',          'penulis' => 'Tim Sinau',   'cat' => 0],
            ['judul' => 'JavaScript Modern ES6+',           'penulis' => 'Pak Budi',    'cat' => 0],
            ['judul' => 'MySQL dari Nol',                   'penulis' => 'Bu Dewi',     'cat' => 1],
            ['judul' => 'Desain Database Relasional',       'penulis' => 'Tim Sinau',   'cat' => 1],
            ['judul' => 'Pengantar Jaringan Komputer',      'penulis' => 'Bu Dewi',     'cat' => 2],
            ['judul' => 'Konfigurasi Router & Switch',      'penulis' => 'Tim Sinau',   'cat' => 2],
            ['judul' => 'Matematika Diskrit untuk SMK',     'penulis' => 'Tim Sinau',   'cat' => 3],
            ['judul' => 'English for IT Professionals',     'penulis' => 'Tim Sinau',   'cat' => 4],
            ['judul' => 'Tailwind CSS & UI Modern',         'penulis' => 'Pak Budi',    'cat' => 0],
        ];
        foreach ($ebookData as $e) {
            Ebook::create([
                'category_id' => $cats[$e['cat']]->id,
                'judul'       => $e['judul'],
                'penulis'     => $e['penulis'],
                'file_path'   => 'ebooks/sample.pdf',
                'jurusan'     => $e['cat'] < 3 ? 'RPL' : null,
            ]);
        }

        // ── Questions ─────────────────────────────────────────────
        $questionData = [
            // Pemrograman Web
            ['cat' => 0, 'p' => 'Apa kepanjangan dari HTML?', 'a' => 'HyperText Markup Language', 'b' => 'High Text Modern Language', 'c' => 'HyperText Modern Link', 'd' => 'High Transfer Markup Language', 'j' => 'a', 't' => 'mudah'],
            ['cat' => 0, 'p' => 'Tag HTML yang digunakan untuk membuat tautan adalah?', 'a' => '<link>', 'b' => '<a>', 'c' => '<href>', 'd' => '<url>', 'j' => 'b', 't' => 'mudah'],
            ['cat' => 0, 'p' => 'Method HTTP yang digunakan untuk mengirim data form adalah?', 'a' => 'GET', 'b' => 'PUT', 'c' => 'POST', 'd' => 'DELETE', 'j' => 'c', 't' => 'sedang'],
            ['cat' => 0, 'p' => 'Framework PHP yang menggunakan konsep MVC adalah?', 'a' => 'jQuery', 'b' => 'Bootstrap', 'c' => 'Laravel', 'd' => 'React', 'j' => 'c', 't' => 'mudah'],
            ['cat' => 0, 'p' => 'Perintah Artisan untuk membuat controller di Laravel adalah?', 'a' => 'php artisan make:model', 'b' => 'php artisan create:controller', 'c' => 'php artisan make:controller', 'd' => 'php artisan new:controller', 'j' => 'c', 't' => 'sedang'],
            ['cat' => 0, 'p' => 'Apa fungsi dari file .env di Laravel?', 'a' => 'Menyimpan template blade', 'b' => 'Konfigurasi environment aplikasi', 'c' => 'Mengatur routing', 'd' => 'Menyimpan session user', 'j' => 'b', 't' => 'mudah'],
            ['cat' => 0, 'p' => 'Properti CSS yang mengatur warna latar belakang adalah?', 'a' => 'color', 'b' => 'font-color', 'c' => 'bg-color', 'd' => 'background-color', 'j' => 'd', 't' => 'mudah'],
            ['cat' => 0, 'p' => 'Di Laravel, ORM yang digunakan untuk berinteraksi dengan database adalah?', 'a' => 'Doctrine', 'b' => 'Eloquent', 'c' => 'Hibernate', 'd' => 'ActiveRecord', 'j' => 'b', 't' => 'sedang'],
            ['cat' => 0, 'p' => 'Apa output dari console.log(typeof null) di JavaScript?', 'a' => 'null', 'b' => 'undefined', 'c' => 'object', 'd' => 'string', 'j' => 'c', 't' => 'sulit'],
            ['cat' => 0, 'p' => 'Directive Blade untuk perulangan di Laravel adalah?', 'a' => '@loop', 'b' => '@repeat', 'c' => '@foreach', 'd' => '@for-each', 'j' => 'c', 't' => 'mudah'],
            // Basis Data
            ['cat' => 1, 'p' => 'Perintah SQL untuk menampilkan semua data dari tabel adalah?', 'a' => 'SHOW * FROM', 'b' => 'SELECT * FROM', 'c' => 'GET * FROM', 'd' => 'FETCH * FROM', 'j' => 'b', 't' => 'mudah'],
            ['cat' => 1, 'p' => 'Constraint yang memastikan nilai kolom bersifat unik dan tidak null adalah?', 'a' => 'UNIQUE', 'b' => 'NOT NULL', 'c' => 'PRIMARY KEY', 'd' => 'FOREIGN KEY', 'j' => 'c', 't' => 'sedang'],
            ['cat' => 1, 'p' => 'Perintah SQL untuk menghapus data dari tabel adalah?', 'a' => 'REMOVE', 'b' => 'DROP', 'c' => 'ERASE', 'd' => 'DELETE', 'j' => 'd', 't' => 'mudah'],
            ['cat' => 1, 'p' => 'JOIN yang menampilkan semua baris dari tabel kiri walaupun tidak ada pasangan adalah?', 'a' => 'INNER JOIN', 'b' => 'RIGHT JOIN', 'c' => 'LEFT JOIN', 'd' => 'FULL JOIN', 'j' => 'c', 't' => 'sedang'],
            ['cat' => 1, 'p' => 'Fungsi agregat SQL untuk menghitung jumlah baris adalah?', 'a' => 'SUM()', 'b' => 'TOTAL()', 'c' => 'COUNT()', 'd' => 'NUM()', 'j' => 'c', 't' => 'mudah'],
            // Jaringan
            ['cat' => 2, 'p' => 'Berapa jumlah bit pada alamat IPv4?', 'a' => '16', 'b' => '32', 'c' => '64', 'd' => '128', 'j' => 'b', 't' => 'mudah'],
            ['cat' => 2, 'p' => 'Protokol yang digunakan untuk mengirim email adalah?', 'a' => 'FTP', 'b' => 'HTTP', 'c' => 'SMTP', 'd' => 'DNS', 'j' => 'c', 't' => 'sedang'],
            ['cat' => 2, 'p' => 'Port default untuk HTTPS adalah?', 'a' => '80', 'b' => '21', 'c' => '8080', 'd' => '443', 'j' => 'd', 't' => 'sedang'],
            // Matematika
            ['cat' => 3, 'p' => 'Hasil dari 2^10 adalah?', 'a' => '512', 'b' => '1024', 'c' => '2048', 'd' => '256', 'j' => 'b', 't' => 'sedang'],
            ['cat' => 3, 'p' => 'Berapakah nilai sin(90°)?', 'a' => '0', 'b' => '-1', 'c' => '0.5', 'd' => '1', 'j' => 'd', 't' => 'mudah'],
            // Bahasa Inggris
            ['cat' => 4, 'p' => 'What is the past tense of "write"?', 'a' => 'writed', 'b' => 'written', 'c' => 'wrote', 'd' => 'writing', 'j' => 'c', 't' => 'mudah'],
            ['cat' => 4, 'p' => 'Choose the correct sentence:', 'a' => 'She don\'t like coding', 'b' => 'She doesn\'t likes coding', 'c' => 'She doesn\'t like coding', 'd' => 'She not like coding', 'j' => 'c', 't' => 'sedang'],
        ];

        $questions = [];
        foreach ($questionData as $q) {
            $questions[] = Question::create([
                'category_id'       => $cats[$q['cat']]->id,
                'pertanyaan'        => $q['p'],
                'opsi_a'            => $q['a'],
                'opsi_b'            => $q['b'],
                'opsi_c'            => $q['c'],
                'opsi_d'            => $q['d'],
                'jawaban_benar'     => $q['j'],
                'tingkat_kesulitan' => $q['t'],
            ]);
        }

        // ── Tryouts ───────────────────────────────────────────────
        $tryout1 = Tryout::create([
            'judul'           => 'Tryout Pemrograman Web #1',
            'durasi_menit'    => 60,
            'tanggal_mulai'   => Carbon::now()->subDays(5),
            'tanggal_selesai' => Carbon::now()->addDays(10),
        ]);
        $tryout1->questions()->attach(collect($questions)->take(10)->pluck('id')->toArray());

        $tryout2 = Tryout::create([
            'judul'           => 'Tryout Basis Data Dasar',
            'durasi_menit'    => 45,
            'tanggal_mulai'   => Carbon::now()->subDays(2),
            'tanggal_selesai' => Carbon::now()->addDays(14),
        ]);
        $tryout2->questions()->attach(collect($questions)->slice(10, 5)->pluck('id')->toArray());

        // ── Badges ────────────────────────────────────────────────
        Badge::insert([
            ['nama' => 'Smeconer Pemula',    'deskripsi' => 'Streak 7 hari berturut-turut',   'milestone_streak' => 7,   'icon' => '🌱', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Smeconer Tangguh',   'deskripsi' => 'Streak 14 hari berturut-turut',  'milestone_streak' => 14,  'icon' => '💪', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Smeconer Berdedikasi','deskripsi' => 'Streak 30 hari berturut-turut', 'milestone_streak' => 30,  'icon' => '🔥', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Smeconer Legendaris','deskripsi' => 'Streak 60 hari berturut-turut',  'milestone_streak' => 60,  'icon' => '⭐', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kinners Master',     'deskripsi' => 'Streak 100 hari berturut-turut', 'milestone_streak' => 100, 'icon' => '👑', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Quests ────────────────────────────────────────────────
        Quest::insert([
            ['judul' => 'Jawab 3 Soal Hari Ini',    'deskripsi' => 'Kerjakan 3 soal latihan hari ini', 'target' => 3,  'poin_reward' => 30,  'tipe' => 'jawab_soal', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Jawab 10 Soal Hari Ini',   'deskripsi' => 'Kerjakan 10 soal latihan hari ini','target' => 10, 'poin_reward' => 80,  'tipe' => 'jawab_soal', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Baca 1 E-Book',             'deskripsi' => 'Buka dan baca minimal 1 e-book',  'target' => 1,  'poin_reward' => 20,  'tipe' => 'baca_ebook', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Buat 1 Study Plan',         'deskripsi' => 'Tambahkan 1 rencana belajar',     'target' => 1,  'poin_reward' => 15,  'tipe' => 'study_plan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Scholarships ──────────────────────────────────────────
        Scholarship::insert([
            ['judul' => 'Beasiswa Unggulan Kemdikbud',       'penyelenggara' => 'Kemdikbud',        'jenjang' => 'S1',  'tipe' => 'Beasiswa Penuh',     'deadline' => Carbon::now()->addDays(30)->toDateString(), 'link' => 'https://beasiswaunggulan.kemdikbud.go.id', 'status' => 'buka', 'deskripsi' => 'Beasiswa penuh dari Kementerian Pendidikan dan Kebudayaan', 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Beasiswa SMK Berprestasi',          'penyelenggara' => 'Dinas Pendidikan', 'jenjang' => 'SMK', 'tipe' => 'Beasiswa Parsial',   'deadline' => Carbon::now()->addDays(15)->toDateString(), 'link' => 'https://disdik.jateng.go.id',              'status' => 'buka', 'deskripsi' => 'Beasiswa untuk siswa SMK berprestasi di Jawa Tengah',    'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Beasiswa Bakti BCA',                'penyelenggara' => 'Bank BCA',         'jenjang' => 'S1',  'tipe' => 'Beasiswa Penuh',     'deadline' => Carbon::now()->addDays(45)->toDateString(), 'link' => 'https://beasiswa.bca.co.id',               'status' => 'buka', 'deskripsi' => 'Program beasiswa dan magang dari Bank BCA',                'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'KIP Kuliah 2026',                   'penyelenggara' => 'Kemendikbud',      'jenjang' => 'S1',  'tipe' => 'KIP Kuliah',         'deadline' => Carbon::now()->addDays(60)->toDateString(), 'link' => 'https://kip-kuliah.kemdikbud.go.id',       'status' => 'buka', 'deskripsi' => 'Kartu Indonesia Pintar Kuliah untuk mahasiswa tidak mampu',  'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Beasiswa SMA Telkom',               'penyelenggara' => 'Telkom Indonesia', 'jenjang' => 'SMA', 'tipe' => 'Beasiswa Parsial',   'deadline' => Carbon::now()->subDays(5)->toDateString(),  'link' => 'https://telkom.co.id/beasiswa',            'status' => 'tutup','deskripsi' => 'Beasiswa untuk siswa SMA dari Telkom Indonesia',           'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Forums ────────────────────────────────────────────────
        $forumData = [
            ['judul' => 'Cara install Laravel di Windows 11?',             'cat' => 0],
            ['judul' => 'Perbedaan LEFT JOIN dan INNER JOIN?',              'cat' => 1],
            ['judul' => 'Tips belajar Bahasa Inggris untuk anak IT',       'cat' => 4],
            ['judul' => 'Kenapa Eloquent lebih populer dari Query Builder?','cat' => 0],
            ['judul' => 'Cara konfigurasi IP statis di Linux?',             'cat' => 2],
        ];

        foreach ($forumData as $i => $f) {
            $forum = Forum::create([
                'user_id'     => $siswaList[$i]->id,
                'category_id' => $cats[$f['cat']]->id,
                'judul'       => $f['judul'],
                'isi'         => 'Halo Smeconers! Ada yang bisa bantu saya tentang topik ini? Saya sudah coba googling tapi masih bingung. Terima kasih sebelumnya ya! — Kinners juga ikut penasaran 🐱',
            ]);

            // Tambah 2 reply per forum
            $forum->replies()->createMany([
                ['user_id' => $siswaList[($i + 1) % 20]->id, 'isi' => 'Wah bagus pertanyaannya! Saya juga lagi nyari jawaban ini hehe.'],
                ['user_id' => $guru1->id,                     'isi' => 'Hai Smeconers! Saya coba bantu jawab ya. Silakan cek dokumentasi resminya juga ya!'],
            ]);
        }
    }
}
