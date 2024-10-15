<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid|unique:users,user_id',
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
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'photo' => $request->photo,
            ]);
            return Redirect::route('users.index')->with('success', 'User created successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while creating the user.']);
        }
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:15',
            'photo' => 'nullable|url',
        ]);

        try {
            $validator->validate();
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'photo' => $request->photo,
            ]);
            return Redirect::route('users.index')->with('success', 'User updated successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while updating the user.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            User::destroy($id);
            return Redirect::route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while deleting the user.']);
        }
    }
}
