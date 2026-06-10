@php
$nav = app(\App\Support\NavigationMenu::class)->flags(auth()->user());
@endphp
@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
    @if($nav['isAdmin'] ?? $nav['isCoordinator'] ?? false)
        @livewire('notificaciones-manager')
    @else
        <p style="color:#666;font-style:italic;">No tienes permiso para gestionar notificaciones.</p>
    @endif
@endsection
