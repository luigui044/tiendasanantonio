<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        $redireccion = '';
        $submodulos = null;
        switch(Auth::user()->rol){
            case 1:
                $submodulos = Modulo::all();
                $redireccion = '/';
            case 2:
                $redireccion = '/';
            break;
            case 3:
                $submodulos = Modulo::where('ban_padre', 3)->get();
                $redireccion = '/submodulos';
            break;
        }
        session(['submodulos' => $submodulos]);
        return $redireccion;
    }

    public function loggedOut(Request $request){
        return redirect('/login');
    }
}
