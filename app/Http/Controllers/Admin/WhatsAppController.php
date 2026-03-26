<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function __construct(protected WhatsAppService $waService) {}

    public function index()
    {
        return view('admin.whatsapp.index');
    }

    // Link WA per siswa dari halaman users
    public function linkSiswa(Request $request, User $user)
    {
        $request->validate([
            'template' => 'required|in:streak,tugas,badge,bebas',
            'pesan'    => 'nullable|string',
            'phone'    => 'nullable|string',
        ]);

        $phone   = $request->phone ?? $user->phone;
        $data    = ['nama' => $user->name, 'pesan' => $request->pesan ?? ''];
        $message = $this->waService->buildMessage($request->template, $data);
        $link    = $this->waService->getWaLink($phone, $message);

        return response()->json(['link' => $link]);
    }

    // Preview & blast ke banyak siswa
    public function blast(Request $request)
    {
        $request->validate([
            'filter'   => 'required|in:semua,kelas,jurusan,streak_kosong',
            'template' => 'required|in:streak,tugas,badge,bebas',
            'pesan'    => 'nullable|string',
            'kelas'    => 'nullable|string',
            'jurusan'  => 'nullable|string',
        ]);

        $query = User::where('role', 'siswa');

        match ($request->filter) {
            'kelas'        => $query->where('kelas', $request->kelas),
            'jurusan'      => $query->where('jurusan', $request->jurusan),
            'streak_kosong'=> $query->whereHas('streak', fn($q) => $q->where('streak_count', 0))
                                    ->orWhereDoesntHave('streak'),
            default        => null,
        };

        $users = $query->get();
        $links = $this->waService->blastLink($users, $request->template, [
            'pesan' => $request->pesan ?? '',
        ]);

        return response()->json([
            'total' => count($links),
            'links' => $links,
        ]);
    }
}
