<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $validator->validate();

            if (Auth::attempt($request->only('email', 'password'))) {
                return Redirect::route('home')->with('success', 'Login successful.');
            }

            return Redirect::back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('login')->with('success', 'Logged out successfully.');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'photo' => 'nullable|url',
        ]);

        try {
            $validator->validate();

            $user = User::create([
                'user_id' => (string) \Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'photo' => $request->photo,
            ]);

            Auth::login($user);
            return Redirect::route('home')->with('success', 'Registration successful.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred during registration.']);
        }
    }
}
