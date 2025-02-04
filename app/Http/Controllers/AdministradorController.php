<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminMiddleware;
use App\Models\User;
use App\Http\Middleware\VerifyMiddleware;
use Illuminate\Support\Facades\Auth;

class AdministradorController extends Controller
{
    public function __construct() {
        $this->middleware(AdminMiddleware::class);
        $this->middleware(VerifyMiddleware::class);
    }

    public function index() {
        $users = null;
        if(!Auth::user()->isSuper()) {
            $users = User::where('id', '<>' , '1')->orderBy('id')->paginate(10);
        }else {
            $users = User::orderBy('id')->paginate(10);
        }
        
        $usersCount = User::count();
        return view('admin.index', ['users' => $users, 'usersCount' => $usersCount]);
    }

}
