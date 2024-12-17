<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(AdminMiddleware::class);
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::where('id', '<>', '1')->orderBy('id')->get();
        }
        return view('user.index', ['users' => $users]);
    }

    public function update(Request $request, User $user)
    {
        if(Auth::user()->isAdmin() && $user->isSuper()) {
            return redirect()->route('user.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        $user->save();


        return redirect()->route('user.index')->with('success', 'Usuario actualizado con éxito');
    }

    public function delete(User $user){
        try {
            if(Auth::user()->isAdmin() && $user->isSuper()) {
                return redirect()->route('user.index');
            }
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Se elimino el usuario exitosamenete');
        }catch(\Exception $error) {

        }

    }
}
