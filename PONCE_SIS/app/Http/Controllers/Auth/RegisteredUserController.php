<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,student'],
            'address' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => 'required|string|max:10',
        ];

        // Add year_level and course validation only for students
        if ($request->input('role') === 'student') {
            $rules['year_level'] = 'required|integer|min:1|max:6';
            $rules['course'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->input('role', 'student'),
            'address' => $request->address,
            'age' => $request->age,
            'phone' => $request->phone,
            'status' => 'not_added_as_student',
            'gender' => $request->gender,
        ];

        // Add year_level and course only for students
        if ($request->input('role') === 'student') {
            $userData['year_level'] = $request->year_level;
            $userData['course'] = $request->course;
        } else {
            // Set default values for admin
            $userData['year_level'] = 1;
            $userData['course'] = 'IT';
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('admin-dashboard');
        } else {
            return redirect()->route('student-dashboard');
        }
    }
}
