@extends('layouts.siswa')
@section('title', 'Riwayat Quiz')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.5rem;}
.page-sub{color:#64748b;font-size:.88rem;font-weight:700;margin-bottom:1.5rem;}
.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
.table-responsive{overflow-x:auto;}
.riwayat-table{width:100%;border-collapse:collapse;font-size:.9rem;}
.riwayat-table th{text-align:left;padding:1rem 1.25rem;background:#f8fafc;border-bottom:2px solid rgba(14,165,233,.1);font-weight:800;color:#1e293b;}
.riwayat-table td{padding:1rem 1.25rem;border-bottom:1px solid rgba(14,165,233,.07);vertical-align:middle;}
.riwayat-table tr:last-child td{border-bottom:none;}
.score-badge{display:inline-block;border-radius:999px;padding:.2rem .7rem;font-size:.78rem;font-weight:800;}
.score-high{background:#dcfce7;color:#16a34a;}
.score-medium{background:#fef9c3;color:#ca8a04;}
.score-low{background:#fee2e2;color:#dc2626;}
.btn-link{color:#0ea5e9;text-decoration:none;font-weight:800;font-size:.85rem;}
.btn-link:hover{text-decoration:underline;}
.empty-msg{text-align:center;padding:3rem;color:#94a3b8;font-weight:700;}
.action-group{display:flex;gap:.5rem;}
</style>

<div class="page-title">📜 Riwayat Quiz</div>
<div class="page-sub">Semua quiz yang sudah kamu kerjakan</div>

<div class="card">
    <div class="table-responsive">
        <table class="riwayat-table">
            <thead>
                <tr>
                    <th>Paket Soal</th>
                    <th>Tanggal Pengerjaan</th>
                    <th>Skor</th>
                    <th>Nilai (%)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attempts as $attempt)
                    @php
                        $percent = $attempt->persentase();
                        $scoreClass = $percent >= 80 ? 'score-high' : ($percent >= 60 ? 'score-medium' : 'score-low');
                    @endphp
                    <tr>
                        <td class="font-weight-bold">{{ $attempt->packet->nama }}</td>
                        <td>{{ $attempt->completed_at ? $attempt->completed_at->format('d M Y H:i') : '-' }}</td>
                        <td>{{ $attempt->skor }} / {{ $attempt->total_poin }}</td>
                        <td>
                            <span class="score-badge {{ $scoreClass }}">
                                {{ $percent }}%
                            </span>
                        </td>
                        <td class="action-group">
                            <a href="{{ route('siswa.quiz.hasil', $attempt) }}" class="btn-link">Lihat Detail</a>
                            @if($attempt->packet->status === 'published')
                                <a href="{{ route('siswa.quiz.show', $attempt->packet) }}" class="btn-link">Kerjakan Ulang</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-msg">
                            📭 Kamu belum pernah mengerjakan quiz apapun.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="text-center" style="margin-top:1.5rem;">
    <a href="{{ route('siswa.quiz.index') }}" class="btn-start" style="display:inline-block;background:#f1f5f9;color:#64748b;padding:.6rem 1.2rem;border-radius:999px;text-decoration:none;font-weight:800;">← Kembali ke Daftar Quiz</a>
</div>

<style>
.btn-start{display:inline-block;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:999px;padding:.6rem 1.2rem;text-align:center;font-weight:800;font-size:.85rem;text-decoration:none;transition:all .2s;border:none;cursor:pointer;}
.btn-start:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(14,165,233,.3);}
</style>
@endsection