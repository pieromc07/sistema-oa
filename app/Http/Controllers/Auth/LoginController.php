<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
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
     * Rules for validate login
     *
     * @var array
     */

    private $rules = [
        'usu_nombre' => 'required|string',
        'usu_contraseña' => 'required|string',
    ];

    /**
     * Messages for validate login
     *
     * @var array
     */

    private $messages = [
        'usu_nombre.required' => 'El nombre de usuario es requerido',
        'usu_contraseña.required' => 'La contraseña es requerida',
    ];

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        $user = User::where('usu_nombre', $request->usu_nombre)->first();

        if ($user) {
            if (password_verify($request->usu_contraseña, $user->usu_contraseña)) {
                Auth::login($user);
                return redirect()->intended($this->redirectPath());
            } else {
                return redirect()->route('login')->withErrors(['usu_contraseña' => 'La contraseña es incorrecta']);
            }
        } else {
            return redirect()->route('login')->withErrors(['usu_nombre' => 'El usuario no existe']);
        }
    }

    public function username()
    {
        return 'usu_nombre';
    }

    public function validateLogin(Request $request)
    {
        $request->validate($this->rules, $this->messages);
    }

    public function loginApiClient(Request $request)
    {
        $document = $request->document;
        $password = $request->password;
        try {
            $client = Cliente::where('cli_numero_documento', $document)->first();

            if ($client) {
                if (password_verify($password, $client->cli_contraseña)) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login success',
                        'data' => $client
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Password incorrect'
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
