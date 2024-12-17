<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    public function updateName(Request $request, User $user)
    {
        if (!$user->isOwner()) {
            return redirect()->route('settings');
        }

        if (!$user->comparePassword($request->current_password)) {
            return redirect()->route('settings')->withErrors(['current_password_username' => 'Las contraseña es invalida']);
        }

        $validate = $request->validate(['name' => 'required|string|min:4|max:25']);

        $user->name = $validate['name'];

        try {
            $user->save();
            return redirect()->route('settings')->with(['success' => 'Se ha moficiado el nombre de manera exitosa']);
        } catch (\Exception $error) {
            return redirect()->route('settings')->withErrors('error', $error);
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        if (!$user->isOwner()) {
            return redirect()->route('settings');
        }

        if (!$user->comparePassword($request->current_password)) {
            return redirect()->route('settings')->withErrors(['current_password_username' => 'Las contraseña es invalida']);
        }

        $validate = $request->validate(['new_password' => 'required|string|min:8|max:40']);

        
        if($validate['new_password'] !== $request->password_confirmation) {
            return redirect()->route('settings')->withErrors(['new_password' => 'Las contraseñas no coninciden']);
        }

        $user->setPassword($validate['new_password']);

        try {
            $user->save();
            return redirect()->route('settings')->with(['success' => 'Se ha moficiado el nombre de manera exitosa']);
        } catch (\Exception $error) {
            return redirect()->route('settings')->withErrors('error', $error);
        }
    }
}
