@extends('layouts.app')


@push('meta')
    <meta name="app-url-update" content="{{ route('users.update', 0) }}">
    <meta name="app-url-delete" content="{{ route('users.destroy', 0) }}">
@endpush

@push('styles')
    <style>
        .editable {
            border-bottom: 1px dashed transparent;
            cursor: pointer;
        }

        .editable:focus {
            border-bottom: 1px dashed #007bff;
            outline: none;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista de Usuarios</h1>

        {{-- Mensajes de éxito o error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Usuarios Registrados</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody id="table">
                        @foreach ($users as $user)
                            @if (Auth::user()->id !== $user->id)
                                <tr data-user-id="{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <span tabindex="-1" class="editable" data-name="name">{{ $user->name }}</span>
                                    </td>
                                    <td>
                                        <span tabindex="-1" class="editable" data-name="email">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <select data-name="role" class="role-select form-select form-select-sm">
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        @if ($user->isSuper())
                                            super
                                        @else
                                            {{ $user->role }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form method="POST" action="" id="formDelete">
        @csrf
        @method('DELETE')
    </form>

    <button type="button" class="btn btn-sm btn-danger d-none position-absolute z-5" id="btn-delete" data-bs-toggle="modal"
        data-bs-target="#deleteModal">
        Eliminar
    </button>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-2">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{-- Botón "Previous" --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a></li>
                @endif
        
                {{-- Primera página --}}
                <li class="page-item {{ $users->currentPage() == 1 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $users->url(1) }}">1</a>
                </li>
        
                {{-- Puntos suspensivos si la página actual está lejos de la primera --}}
                @if ($users->currentPage() > 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
        
                {{-- Páginas alrededor de la página actual --}}
                @foreach ($users->getUrlRange(max(2, $users->currentPage() - 1), min($users->lastPage() - 1, $users->currentPage() + 1)) as $page => $url)
                    <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
        
                {{-- Puntos suspensivos si la página actual está lejos de la última --}}
                @if ($users->currentPage() < $users->lastPage() - 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
        
                {{-- Última página --}}
                @if ($users->lastPage() > 1)
                    <li class="page-item {{ $users->currentPage() == $users->lastPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                    </li>
                @endif
        
                {{-- Botón "Next" --}}
                @if ($users->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endsection

@push('scripts')
    <script src="{{ url('/js/saveUpdate.js') }}"></script>
    <script src="{{ url('/js/deleteForm.js') }}"></script>
@endpush
