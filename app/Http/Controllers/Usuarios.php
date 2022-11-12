<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rol;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class Usuarios extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $usuario = new User();

        $usuario->name = $request->name;
        $usuario->password =  Hash::make($request->password);
        $usuario->rol = $request->rol;
        $usuario->email = $request->email;
        $usuario->save();

        return back()->with('mensaje', 'Usuario '.$request->email.' agregado éxitosamente');

    }
    public function cambioRol(Request $request)
    {
        $usuario = User::findOrFail($request->user);
        $usuario->rol = $request->rol;
        $usuario->save();

        return back()->with('mensaje', 'Rol de usuario '.$usuario->name.' actualizado éxitosamente');

    }

    public function actUser($id)
    {
        $rol = Rol::all();
        $usuario = User::findOrFail($id);
        return view('usuarios.actualizacion', compact('id','usuario','rol'));
    }

    public function actUser2(Request $request,$id)
    {
        $usuario = User::findOrFail($id);
    
        if($usuario->name != $request->name)
        {
            $usuario->name = $request->name;
        }

        if( $usuario->rol != $request->rol   && $usuario->rol != null)
        {
            $usuario->rol = $request->rol;
        }

        if($usuario->ban_estado != $request->estado && $usuario->ban_estado != null )
        {
            $usuario->ban_estado = $request->estado;          
        }
        
        if($usuario->email != $request->email )
        {
            $usuario->email = $request->email;
        }

        $usuario->save();
        return back()->with('mensaje', 'Información de usuario '.$usuario->name.' actualizada éxitosamente');

    }

    public function resetpass(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->password =  Hash::make("FarmFacturAccess");
        $usuario->ban_reset = 1;
        $usuario->save();
        return back()->with('mensaje2', 'Contraseña reestablecida. Utilizar contraseña temporal "FarmFacturAccess" ');

    }

    public function cambiarPass(Request $request)
    {   
        $p1 = $request->password;
         $p2= $request->password_confirmation;
        if ($p1==$p2) {
            $id =auth()->user()->id;

            $usuario = User::findOrFail($id);
            $usuario->password =  Hash::make($p1);
            $usuario->ban_reset = 0;
            $usuario->save();
            $mensaje = 'Contraseña reestablecida';
            return redirect()->route('home')->with( ['mensaje' => $mensaje]);
        
        } else {
            return back()->with('mensaje', 'Las contraseñas no coinciden');
        }
        

        
    }


}
