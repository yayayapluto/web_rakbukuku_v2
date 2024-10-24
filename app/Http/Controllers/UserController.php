<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Import Str
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('private.users.index', compact('users'));
    }

    public function create()
    {
        return view('private.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:15',
            'photo' => 'nullable|url',
        ]);

        try {
            $validator->validate();

            User::create([
                'user_id' => (string) Str::uuid(), // Generate UUID
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'photo' => $request->photo,
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'User created successfully.',
                'route' => route('users.index'),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while creating the user.',
            ]);
        }
    }

    public function show(string $uuid)
    {
        $user = User::where('user_id', $uuid)->firstOrFail();
        return view('private.users.show', compact('user'));
    }

    public function edit(string $uuid)
    {
        $user = User::where('user_id', $uuid)->firstOrFail();
        return view('private.users.edit', compact('user'));
    }

    public function update(Request $request, string $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $uuid . ',user_id',
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:15',
            'photo' => 'nullable|url',
        ]);

        try {
            $validator->validate();
            $user = User::where('user_id', $uuid)->firstOrFail();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'photo' => $request->photo,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'User updated successfully.',
                'route' => route('users.index'),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while updating the user.',
            ]);
        }
    }

    public function destroy(string $uuid)
    {
        try {
            User::where('user_id', $uuid)->firstOrFail()->delete();
            return response()->json([
                'success' => true,
                'msg' => 'User deleted successfully.',
                'route' => route('users.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while deleting the user.',
            ]);
        }
    }
}
