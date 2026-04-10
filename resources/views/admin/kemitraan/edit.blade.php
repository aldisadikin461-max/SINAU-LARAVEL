@extends('layouts.admin')

@section('title', 'Edit Mitra — Admin Sinau')

@section('content')

@include('admin.kemitraan._form', [
  'action' => route('admin.kemitraan.update', $kemitraan->id),
  'method' => 'PUT',
  'mitra'  => $kemitraan,
  'title'  => '✏️ Edit Mitra: ' . $kemitraan->nama,
])

@endsection