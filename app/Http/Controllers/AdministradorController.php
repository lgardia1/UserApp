<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Models\User;

class AdministradorController extends Controller
{
    public function __construct() {
        $this->middleware(AdminMiddleware::class)->only('index');
        $this->middleware(SuperAdminMiddleware::class)->only('indexSuper');
    }

    public function index() {
        $users = User::where('id', '<>' , '1')->orderBy('name')->get();
        $usersCount = User::count();
        return view('admin.index', ['users' => $users, 'usersCount' => $usersCount]);
    }

    public function indexSuper() {
        
    }


}
