@extends('layouts.siswa')
@section('title','Forum')
@section('content')
<style>
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
  .top-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;}
  .filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;}
  .finput{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;font-size:.88rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;}
  .finput:focus{border-color:#0ea5e9;}
  .fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
  .btn-new{padding:.55rem 1.4rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.9rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
  .thread-list{display:flex;flex-direction:column;gap:1rem;}
  .tcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem 1.5rem;box-shadow:0 3px 14px rgba(14,165,233,.07);transition:all .2s;}
  .tcard:hover{box-shadow:0 8px 28px rgba(14,165,233,.12);}
  .tcard-head{margin-bottom:.6rem;}
  .tcard-title{font-family:'Fredoka One',sans-serif;font-size:1.05rem;color:#0f172a;margin-bottom:.3rem;}
  .tmeta{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;font-size:.78rem;font-weight:700;color:#94a3b8;}
  .tcat{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.15rem .65rem;font-size:.76rem;font-weight:800;}
  .tisi{color:#64748b;font-size:.88rem;line-height:1.6;margin-bottom:.85rem;font-weight:600;}
  .treply-form{display:flex;gap:.5rem;}
  .treply-input{flex:1;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:999px;padding:.45rem 1rem;font-size:.85rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
  .treply-input:focus{border-color:#0ea5e9;background:#fff;}
  .treply-btn{padding:.45rem 1.1rem;border-radius:999px;background:#0ea5e9;color:#fff;font-size:.82rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
  .replies{margin-top:.85rem;padding-left:1rem;border-left:3px solid #e0f2fe;display:flex;flex-direction:column;gap:.5rem;}
  .reply-item{font-size:.84rem;}
  .reply-name{font-weight:800;color:#0284c7;}
  .reply-text{color:#475569;font-weight:600;margin-left:.4rem;}
  .reply-time{color:#cbd5e1;font-size:.74rem;margin-left:.4rem;}
  /* Modal */
  .modal-bg{display:none;position:fixed;inset:0;background:rgba(15,23,42,.25);backdrop-filter:blur(4px);z-index:200;align-items:center;justify-content:center;padding:1rem;}
  .modal-bg.open{display:flex;}
  .modal{background:#fff;border-radius:1.5rem;padding:2rem;width:100%;max-width:560px;box-shadow:0 16px 48px rgba(14,165,233,.15);}
  .modal-title{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:#0f172a;margin-bottom:1.25rem;display:flex;justify-content:space-between;align-items:center;}
  .modal-close{font-size:1.2rem;cursor:pointer;color:#94a3b8;background:none;border:none;}
  .mlabel{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.3rem;}
  .minput{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.15);border-radius:.875rem;padding:.6rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.85rem;transition:border-color .2s;}
  .minput:focus{border-color:#0ea5e9;background:#fff;}
  .msubmit{width:100%;padding:.7rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
</style>
<div class="top-row">
  <div class="page-title" style="margin-bottom:0;">💬 Forum Diskusi</div>
  <button class="btn-new" onclick="document.getElementById('modal-forum').classList.add('open')">+ Buat Thread</button>
</div>
<form method="GET" class="filter-row">
  <select name="category_id" class="finput">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">Filter</button>
</form>
<div class="thread-list">
  @forelse($threads as $thread)
    <div class="tcard">
      <div class="tcard-head">
        <div class="tcard-title">{{ $thread->judul }}</div>
        <div class="tmeta">
          <span>👤 {{ $thread->user->name }}</span>
          <span class="tcat">{{ $thread->category->nama_kategori }}</span>
          <span>{{ $thread->created_at->diffForHumans() }}</span>
          <span>💬 {{ $thread->replies->count() }} balasan</span>
        </div>
      </div>
      <div class="tisi">{{ Str::limit($thread->isi,150) }}</div>
      <form method="POST" action="{{ route('siswa.forum.reply',$thread) }}" class="treply-form">
        @csrf
        <input name="isi" class="treply-input" placeholder="Tulis balasan...">
        <button type="submit" class="treply-btn">Kirim</button>
      </form>
      @if($thread->replies->count())
        <div class="replies">
          @foreach($thread->replies->take(2) as $r)
            <div class="reply-item">
              <span class="reply-name">{{ $r->user->name }}</span>
              <span class="reply-text">{{ $r->isi }}</span>
              <span class="reply-time">{{ $r->created_at->diffForHumans() }}</span>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  @empty
    <div style="text-align:center;padding:3rem;background:#fff;border-radius:1.25rem;color:#94a3b8;">
      <div style="font-size:2.5rem;margin-bottom:.5rem;">🐱</div>
      <p style="font-weight:700;">Forum masih sepi. Kinners nunggu diskusi pertamamu!</p>
    </div>
  @endforelse
</div>
<div style="margin-top:1.25rem;">{{ $threads->links() }}</div>

<div id="modal-forum" class="modal-bg">
  <div class="modal">
    <div class="modal-title">
      Buat Thread Baru
      <button class="modal-close" onclick="document.getElementById('modal-forum').classList.remove('open')">✕</button>
    </div>
    <form method="POST" action="{{ route('siswa.forum.store') }}">
      @csrf
      <label class="mlabel">Kategori</label>
      <select name="category_id" class="minput">
        @foreach($categories as $c)
          <option value="{{ $c->id }}">{{ $c->nama_kategori }}</option>
        @endforeach
      </select>
      <label class="mlabel">Judul Thread</label>
      <input name="judul" class="minput" placeholder="Pertanyaan atau topik diskusi...">
      <label class="mlabel">Deskripsi</label>
      <textarea name="isi" class="minput" rows="4" style="resize:none;border-radius:.875rem;" placeholder="Jelaskan lebih detail..."></textarea>
      <button type="submit" class="msubmit">Posting Thread 🚀</button>
    </form>
  </div>
</div>
@endsection