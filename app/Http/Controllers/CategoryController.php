<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;

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
            'image' => 'nullable|max:1024',
        ]);

        try {
            $validator->validate();
            $imagePath = $this->handleImageUpload($request);

            $category = Category::create([
                'category_id' => Str::uuid(),
                'name' => $request->name,
                'image' => $imagePath,
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while creating the category. ' . $e->getMessage(),
                'error' => $e->getMessage(),
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
            'name' => 'required|string|max:255',
            'image' => 'nullable|max:1024',
        ]);

        try {
            $validator->validate();
            $category = Category::where('category_id', $uuid)->firstOrFail();

            // Handle image update if uploaded
            $imagePath = $this->handleImageUpload($request, $category->image);

            $category->update([
                'name' => $request->name,
                'image' => $imagePath ?? $category->image, // Use the old image if no new one is provided
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Category updated successfully.',
                'category' => $category,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation failed.' . $e,
                'errors' => $validator->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while updating the category.' . $e,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $uuid)
    {
        try {
            $category = Category::where('category_id', $uuid)->firstOrFail();
            $category->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Category deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while deleting the category.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle image upload logic.
     *
     * @param Request $request
     * @param string|null $oldImagePath
     * @return string|null
     */
    private function handleImageUpload(Request $request, string $oldImagePath = null)
    {
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($oldImagePath && Storage::exists('public/' . $oldImagePath)) {
                Storage::delete('public/' . $oldImagePath);
            }

            $image = $request->file('image');
            $imageName = "upload_" . date("ymd") . "_" . time() . "_" . $image->getClientOriginalName();
            return $image->storeAs('categories', $imageName, ['disk' => 'public']);
        }

        return null; // No new image uploaded
    }
}
