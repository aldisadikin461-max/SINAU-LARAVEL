@extends('layouts.admin')

@section('title', 'Tambah Mitra — Admin Sinau')

@section('content')

@include('admin.kemitraan._form', [
  'action' => route('admin.kemitraan.store'),
  'method' => 'POST',
  'mitra'  => null,
  'title'  => '➕ Tambah Mitra Baru',
])

@endsection