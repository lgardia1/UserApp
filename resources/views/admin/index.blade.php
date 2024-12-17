@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-dark text-white vh-100">
            <div class="py-4 text-center">
                <h2>Admin Panel</h2>
                <p class="small text-muted">Bienvenido, {{ Auth::user()->name }}</p>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link text-white" href="">📊 Dashboard</a>
                <a class="nav-link text-white" href="{{ route('user.index') }}">👥 Usuarios</a>
                <a class="nav-link text-white" href="{{ route('settings') }}">⚙️ Configuración</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="py-4">
                <h1 class="text-primary">📊 Dashboard</h1>
                <p class="text-muted">Resumen de actividades y estadísticas</p>

                <!-- Cards -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios registrados</h5>
                                <p class="card-text fs-2">{{ $usersCount }}</p>
                                <a href="{{ route('user.index') }}" class="btn btn-primary">Ver usuarios</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Ingresos del mes</h5>
                                <p class="card-text fs-2">$2,350</p>
                                <a href="#" class="btn btn-success">Ver reportes</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Tareas pendientes</h5>
                                <p class="card-text fs-2">5</p>
                                <a href="#" class="btn btn-warning">Revisar tareas</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="mt-5">
                    <h2 class="text-secondary">Últimos registros</h2>
                    <table class="table table-hover shadow-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="{{ route('users.destroy', $user->id) }}" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
