<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:SuperAdmin,SchoolAdmin,Teacher,Student,Parent,Bursar'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign the selected role to the user
        $user->assignRole($data['role']);

        return $user;
    });
    }

    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->hasRole('SuperAdmin')) {
            return '/superadmin/dashboard';
        } elseif ($user->hasRole('SchoolAdmin')) {
            return '/schooladmin/dashboard';
        } elseif ($user->hasRole('Teacher')) {
            return '/teacher/dashboard';
        } elseif ($user->hasRole('Student')) {
            return '/student/dashboard';
        } elseif ($user->hasRole('Parent')) {
            return '/parent/dashboard';
        } elseif ($user->hasRole('Bursar')) {
            return '/bursar/dashboard';
        }

        return '/dashbord';
    }

     protected function registered(Request $request, $user)
    {
        // Custom success message with user's name
        session()->flash('success', "Welcome aboard, {$user->name}! Your registration was successful.");
    }
}
