<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

      protected function authenticated(Request $request, $user)
    {
        // Custom success message with user's name
        session()->flash('success', "Welcome back, {$user->name}! You have successfully logged in.");

        if ($user->hasRole('SuperAdmin')) {
            return redirect('/admin/dashboard');
        } elseif ($user->hasRole('SchoolAdmin')) {
            return redirect('/school/dashboard');
        } elseif ($user->hasRole('Teacher')) {
            return redirect('/teacher/dashboard');
        } elseif ($user->hasRole('Student')) {
            return redirect('/student/dashboard');
        } elseif ($user->hasRole('Parent')) {
            return redirect('/parent/dashboard');
        } elseif ($user->hasRole('Bursar')) {
            return redirect('/bursar/dashboard');
        }
        
        return redirect('/dashboard');
    }

     protected function loggedOut(Request $request)
    {
        session()->flash('info', 'You have been successfully logged out. Come back soon!');
    }
}
