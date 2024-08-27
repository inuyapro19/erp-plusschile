<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'rut';
    }

    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return response('success', 200);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->primer_login == 'Y' && $user->cambio_contrasena == 'N') {
           // Session::flash('danger', 'Debe cambiar la contraseña');
            return redirect(route('profile.edit', $user->rut));
        }

        // Mapeo de permisos a rutas de dashboard
        $dashboardRoutes = [
            'dashboard admin' => 'dashboard.administrador',
            'dashboard rrhh' => 'dashboard.rrhh',
            'dashboard operaciones' => 'home.operaciones',
            'dashboard calidad' => 'dashboard.calidad',
            'dashboard trabajador' => 'dashboard.trabajador',
        ];

        foreach ($dashboardRoutes as $permission => $routeName) {
            if ($user->can($permission)) {
                return redirect()->route($routeName);
            }
        }
        // Redireccionar a home si no tiene permisos para ver ningún dashboard
        //return redirect('/home');

    }


}
