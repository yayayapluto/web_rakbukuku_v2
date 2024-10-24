<?php

namespace App\Http\Controllers;

use Hash;
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
                $route = "home";

                if (User::where("email", $request->email)->value("is_admin")) {
                    $route = "admin.dashboard";
                }
                // return Redirect::route('home')->with('success', 'Login successful.');
                return response()->json([
                    "success" => true,
                    "msg" => "Berhasil masuk",
                    "route" => route($route)
                ]);
            }

            // return Redirect::back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
            return response()->json([
                "success" => false,
                "msg" => "Email atau password salah nih",
                "route" => route("login")
            ]);
        } catch (ValidationException $e) {
            // return Redirect::back()->withErrors($validator)->withInput();
            return response()->json([
                "success" => false,
                "msg" => "Coba masuk lagi dehh",
                "route" => route("login")
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('login')->with('success', 'Berhasil keluar');
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
            'password' => 'required|string|min:8',
            'gender' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Silakan masukkan alamat email yang valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'gender.in' => 'Gender harus berupa male, female, atau other.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
        ]);

        try {
            $validator->validate();

            $user = User::create([
                'user_id' => (string) \Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
            ]);
            // return Redirect::route('home')->with('success', 'Registration successful.');
            return response()->json([
                "success" => true,
                "msg" => "Berhasil registrasi",
                "route" => route("login")
            ]);
        } catch (ValidationException $e) {
            // return Redirect::back()->withErrors($validator)->withInput();
            return response()->json([
                "success" => false,
                "msg" => implode("\n",$e->validator->errors()->all()),
                "route" => route("register")
            ]);
        } catch (\Exception $e) {
            // return Redirect::back()->withErrors(['error' => 'An error occurred during registration.']);
            return response()->json([
                "success" => false,
                "msg" => "Coba registrasi ulang deh",
                "route" => route("register")
            ]);
        }
    }
}
