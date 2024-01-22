<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index()
    {
        $iduser = auth()->id();
        $count = DB::select(
            DB::raw("SELECT count(id) as total_items from drivedealio.carts where users_id = $iduser;")
        );
        $user = User::findOrFind($iduser);
        return view('layout.main', compact('count', 'user'));
    }

}
