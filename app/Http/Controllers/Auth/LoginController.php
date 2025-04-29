<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

    public function showLoginForm()
{
    Session::invalidate();        // Borra la sesión vieja
    Session::regenerate();         // Crea una nueva ID de sesión
    Session::regenerateToken();    // Crea un nuevo token CSRF

    return view('auth.login');     // Carga tu vista de login normalmente
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

    public function loggedOut(Request $request)
    {
        $request->session()->invalidate();    // Borra la sesión
        $request->session()->regenerateToken(); // Crea nuevo token CSRF

        return redirect('/login');
    }
}
