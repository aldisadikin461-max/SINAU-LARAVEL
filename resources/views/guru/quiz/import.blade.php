@extends('layouts.guru')
@section('title','Import Paket Soal')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:0.5rem;}
.page-desc{color:#64748b;font-size:.9rem;font-weight:600;margin-bottom:1.5rem;}

.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);padding:2rem;}
.salert{background:#dcfce7;border:1px solid #bbf7d0;color:#16a34a;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}
.salert-e{background:#fee2e2;border:1px solid #fecaca;color:#dc2626;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}

.import-box {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 2px dashed rgba(14,165,233,.35);
    border-radius: 1.25rem;
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: center;
}
.import-box-title {
    font-family: 'Fredoka One', sans-serif;
    font-size: 1.2rem;
    color: #0284c7;
    margin-bottom: 1rem;
}
.import-form-row {
    display: flex;
    gap: 1rem;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}
.import-file-input {
    min-width: 280px;
    padding: .6rem 1rem;
    border: 2px solid rgba(14,165,233,.2);
    border-radius: .875rem;
    font-size: .9rem;
    font-weight: 700;
    font-family: 'Nunito', sans-serif;
    background: #fff;
    cursor: pointer;
}
.btn-submit {
    padding: .6rem 1.6rem;
    border-radius: 999px;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff;
    font-size: .9rem;
    font-weight: 800;
    text-decoration: none;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(14,165,233,.3);
    transition: all .2s;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(14,165,233,.4);
}
.btn-back {
    display: inline-block;
    padding: .5rem 1.2rem;
    border-radius: 999px;
    background: #f1f5f9;
    color: #475569;
    font-size: .88rem;
    font-weight: 800;
    text-decoration: none;
    transition: all .2s;
}
.btn-back:hover {
    background: #e2e8f0;
}
.import-note {
    font-size: .85rem;
    color: #64748b;
    font-weight: 600;
    line-height: 1.6;
    text-align: center;
}
.import-note code {
    background: rgba(14,165,233,.1);
    color: #0284c7;
    padding: .1rem .4rem;
    border-radius: .3rem;
    font-weight: 700;
}
</style>

@if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif
@if(session('error'))<div class="salert-e">⚠️ {{ session('error') }}</div>@endif

<div class="page-title">📥 Import Paket Soal</div>
<div class="page-desc">Upload file Excel untuk menambahkan ratusan soal dalam satu klik.</div>

<div class="card">
    <div class="import-box">
        <div class="import-box-title">Upload Data Excel</div>
        <form action="{{ route('guru.quiz.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="import-form-row">
                <input type="file" name="file" class="import-file-input" accept=".xlsx,.xls" required>
                <button type="submit" class="btn-submit">
                    🚀 Upload & Import
                </button>
            </div>
            @error('file')
                <div style="color:#dc2626;font-size:.85rem;font-weight:700;margin-top:.5rem;">⚠️ {{ $message }}</div>
            @enderror
        </form>
        <div class="import-note">
            Format file harus <strong>.xlsx</strong> atau <strong>.xls</strong>. <br>
            Pastikan kolom di Sheet 1 memuat <code>nama_paket</code>, baris di Sheet 2 memuat soal.
        </div>
    </div>
    
    <div style="text-align: center;">
        <a href="{{ route('guru.quiz.index') }}" class="btn-back">⬅️ Kembali ke Paket Soal</a>
    </div>
</div>

@endsection