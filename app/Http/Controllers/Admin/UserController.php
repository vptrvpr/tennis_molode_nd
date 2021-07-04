<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;

class UserController extends Controller
{
    public function get()
    {
        $users = User::with( 'roles' )->get();
        return response()->json( $users );
    }


    public function active( $userId )
    {
        $user            = User::where( 'id', $userId )->first();
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json( [ 'text' => 'Успешно обновлено' ] );
    }


    public function admin( $userId )
    {
        $user = User::where( 'id', $userId )->first();
        $role = Role::where( 'id', 1 )->first();

        $user->attachRole( $role );

        return response()->json( [ 'text' => 'Админ успешно назначен' ] );
    }


    public function delete( $userId )
    {

        User::where( 'id', $userId )->delete();

        return response()->json( [ 'text' => 'Пользователь успешно удален' ] );
    }
}
