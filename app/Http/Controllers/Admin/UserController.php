<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get()
    {
        $users = User::all();
        return response()->json( $users );
    }


    public function active( $userId )
    {
        $user            = User::where( 'id', $userId )->first();
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json( [ 'text' => 'Успешно обновлено' ] );
    }
}
