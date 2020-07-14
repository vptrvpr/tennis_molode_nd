<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUserMail;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'guest' );
    }


    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function registered( Request $request, User $user )
    {
        if( $user instanceof MustVerifyEmail ) {
            $user->sendEmailVerificationNotification();

            return response()->json( [ 'status' => trans( 'verification.sent' ) ] );
        }

        return response()->json( $user );
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator( array $data )
    {
        return Validator::make( $data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ] );
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\User
     */
    protected function create( array $data )
    {
        $user = config( 'roles.models.defaultUser' )::create( [
                                                                  'name'     => $data[ 'name' ],
                                                                  'email'    => $data[ 'email' ],
                                                                  'password' => bcrypt( $data[ 'password' ] ),
                                                              ] );

        $role = config( 'roles.models.role' )::where( 'name', '=', 'User' )->first();  //choose the default role upon user creation.
        $user->attachRole( $role );

        \Mail::queue( new NewUserMail( $user ) );

        return $user;
    }
}
