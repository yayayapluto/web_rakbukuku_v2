<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rack;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Str;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::all();
        return view('private.racks.index', compact('racks'));
    }

    public function create()
    {
        return view('private.racks.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();
            $rack = Rack::create([
                'rack_id' => Str::uuid(),
                'name' => $request->name,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'Rack created successfully.',
                'rack' => $rack,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating rack: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while creating the rack.',
            ], 500);
        }
    }

    public function show(string $uuid)
    {
        $rack = Rack::where('rack_id', $uuid)->firstOrFail();
        return view('private.racks.show', compact('rack'));
    }

    public function edit(string $uuid)
    {
        $rack = Rack::where('rack_id', $uuid)->firstOrFail();
        return view('private.racks.edit', compact('rack'));
    }

    public function update(Request $request, string $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:racks,name,' . $uuid . ',rack_id',
        ]);

        try {
            $validator->validate();
            $rack = Rack::where('rack_id', $uuid)->firstOrFail();
            $rack->update([
                'name' => $request->name,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'Rack updated successfully.',
                'rack' => $rack,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating rack: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while updating the rack.',
            ], 500);
        }
    }

    public function destroy(string $uuid)
    {
        try {
            $rack = Rack::where('rack_id', $uuid)->firstOrFail();
            $rack->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Rack deleted successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting rack: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while deleting the rack.',
            ], 500);
        }
    }
}
