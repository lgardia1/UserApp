@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Bienvenido</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-3">Explora las opciones disponibles:</p>
                        <div class="list-group">
                            @if (!Auth::check())
                                <a href="{{ route('login') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-sign-in-alt"></i> <span class="ms-2">Login</span>
                                </a>
                            @endif
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-home"></i> Home
                            </a>
                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span class="ms-2">Admin Panel</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        © {{ date('Y') }} {{ __('Tu aplicacion') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
