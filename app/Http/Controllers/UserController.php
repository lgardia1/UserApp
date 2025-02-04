<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifyMiddleware;

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
        if ($user->isSuper()) {
            return response()->json(['error' => 'Acción no permitida'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|min:2',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|in:user,admin',
        ]);

        try {
            // Verifica si hay datos para actualizar
            if (empty($validated)) {
                return response()->json(['error' => 'No se enviaron datos válidos para actualizar'], 400);
            }
    
            // Actualiza el usuario
            $user->update($request->all());
    
            return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user], 200);
        } catch (\Exception $error) {
            return response()->json(["error" => "Error inesperado: " . $error->getMessage()], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->isSuper()) {
                return redirect()->route('users.index');
            }
            $user->delete();

            $page = request()->query('page', 1);

            return redirect()->route('users.index', ['page' => $page])->with(['success' => 'Se elimino el usuario exitosamenete']);
        } catch (\Exception $error) {
            return redirect()->route('users.index')->with(['error' => 'No se ha podido eliminado el usuario: ' . $error]);
        }
    }
}
