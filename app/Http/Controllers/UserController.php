<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifyMiddleware;
use Illuminate\Support\Carbon;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(AdminMiddleware::class);
        $this->middleware(VerifyMiddleware::class);
    }

    public function index()
    {
        if (!Auth::user()->isSuper()) {
            $users = User::where('id', '<>', '1')->orderBy('id')->paginate(12);
        }else {
            $users = User::orderBy('id')->paginate(12);
        }
   
        return view('admin.user.index', ['users' => $users]);
    }

    public function update(Request $request, User $user) 
    {
        if ($user->isSuper() || (Auth::user()->id === $user->id)) {
            return response()->json(['error' => 'Acción no permitida'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|min:2',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|in:user,admin',
            'verify' => 'sometimes|in:Verify'
        ]);

        try {
            // Verifica si hay datos para actualizar
            if (empty($validated)) {
                return response()->json(['error' => 'No se enviaron datos válidos para actualizar'], 400);
            }

            if(isset($validated['verify'])) {
                $dateNow = Carbon::now();
                $validated['email_verified_at'] = $dateNow;
            }
    
            // Actualiza el usuario
            $user->update($validated);
    
            return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user], 200);
        } catch (\Exception $error) {
            return response()->json(["error" => "Error inesperado: " . $error->getMessage()], 500);
        }
    }

    public function destroy(Request $request, User $user)
    {
        try {
            // Verifica si el usuario es superusuario
            if ($user->isSuper() || (Auth::user()->id === $user->id)) {
                return redirect()->route('users.index');
            }
    
            // Elimina el usuario
            $user->delete();
    
            // Obtiene el número de página actual o usa 1 por defecto
            if($request->page) {
                $page = $request->page;
            }else {
                $page = 1;
            }
    
            // Redirige a la lista de usuarios con el parámetro de paginación
            return redirect()->route('users.index', ['page' => $page])
                ->with('success', 'Se eliminó el usuario exitosamente');
        } catch (\Exception $error) {
            // Manejo de errores
            return redirect()->route('users.index')
                ->with('error', 'No se ha podido eliminar el usuario: ' . $error->getMessage());
        }
    }
}
