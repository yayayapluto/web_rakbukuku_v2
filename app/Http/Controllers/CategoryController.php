<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|uuid|unique:categories,category_id',
            'name' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();
            Category::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
            ]);
            return Redirect::route('categories.index')->with('success', 'Category created successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while creating the category.']);
        }
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        try {
            $validator->validate();
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
            ]);
            return Redirect::route('categories.index')->with('success', 'Category updated successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while updating the category.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            Category::destroy($id);
            return Redirect::route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while deleting the category.']);
        }
    }
}
