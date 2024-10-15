<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rack;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::all();
        return view('racks.index', compact('racks'));
    }

    public function create()
    {
        return view('racks.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rack_id' => 'required|uuid|unique:racks,rack_id',
            'name' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();
            Rack::create([
                'rack_id' => $request->rack_id,
                'name' => $request->name,
            ]);
            return Redirect::route('racks.index')->with('success', 'Rack created successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while creating the rack.']);
        }
    }

    public function show(string $id)
    {
        $rack = Rack::findOrFail($id);
        return view('racks.show', compact('rack'));
    }

    public function edit(string $id)
    {
        $rack = Rack::findOrFail($id);
        return view('racks.edit', compact('rack'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:racks,name,' . $id,
        ]);

        try {
            $validator->validate();
            $rack = Rack::findOrFail($id);
            $rack->update([
                'name' => $request->name,
            ]);
            return Redirect::route('racks.index')->with('success', 'Rack updated successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while updating the rack.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            Rack::destroy($id);
            return Redirect::route('racks.index')->with('success', 'Rack deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while deleting the rack.']);
        }
    }
}
