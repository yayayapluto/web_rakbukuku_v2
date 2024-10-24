<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('private.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('private.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();
            $category = Category::create([
                'category_id' => Str::uuid(),
                'name' => $request->name,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'Category created successfully.',
                'category' => $category,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while creating the category.',
            ], 500);
        }
    }

    public function show(string $uuid)
    {
        $category = Category::where('category_id', $uuid)->firstOrFail();
        return view('private.categories.show', compact('category'));
    }

    public function edit(string $uuid)
    {
        $category = Category::where('category_id', $uuid)->firstOrFail();
        return view('private.categories.edit', compact('category'));
    }

    public function update(Request $request, string $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $uuid . ',category_id',
        ]);

        try {
            $validator->validate();
            $category = Category::where('category_id', $uuid)->firstOrFail();
            $category->update([
                'name' => $request->name,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'Category updated successfully.',
                'category' => $category,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while updating the category.',
            ], 500);
        }
    }

    public function destroy(string $uuid)
    {
        try {
            Category::where('category_id', $uuid)->firstOrFail()->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Category deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while deleting the category.',
            ], 500);
        }
    }
}
