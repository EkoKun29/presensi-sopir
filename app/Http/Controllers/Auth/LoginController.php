<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function posts(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'email' => 'email|exists:users,email',
                    'password' => 'required',

                ]
            );

            $attempts = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($attempts)) {
                return redirect()->intended('home');
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Maaf email atau password yang anda masukkan salah, Silahkan login kembali!');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
