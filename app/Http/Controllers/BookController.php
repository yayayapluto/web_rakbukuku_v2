<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Rack;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;
use Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['rack', 'category'])->get();
        return view('private.books.index', compact('books'));
    }

    public function create()
    {
        $racks = Rack::all();
        $categories = Category::all();
        return view('private.books.create', compact('racks', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rack_id' => 'required|uuid|exists:racks,rack_id',
            'category_id' => 'required|uuid|exists:categories,category_id',
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publish_year' => 'required|integer',
            'cover' => 'nullable|url',
            'soft_file' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            $request["book_id"] = Str::uuid();
            $validator->validate();
            $book = Book::create($request->all());
            return response()->json([
                'success' => true,
                'msg' => 'Book created successfully.',
                'book' => $book,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating book: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while creating the book.',
            ], 500);
        }
    }

    public function show(string $uuid)
    {
        $book = Book::with(['rack', 'category'])->where('book_id', $uuid)->firstOrFail();
        return view('private.books.show', compact('book'));
    }

    public function edit(string $uuid)
    {
        $book = Book::where('book_id', $uuid)->firstOrFail();
        $racks = Rack::all();
        $categories = Category::all();
        return view('private.books.edit', compact('book', 'racks', 'categories'));
    }

    public function update(Request $request, string $uuid)
    {
        $validator = Validator::make($request->all(), [
            'rack_id' => 'required|uuid|exists:racks,rack_id',
            'category_id' => 'required|uuid|exists:categories,category_id',
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $uuid . ',book_id',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publish_year' => 'required|integer',
            'cover' => 'nullable|url',
            'soft_file' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            $validator->validate();
            $book = Book::where('book_id', $uuid)->firstOrFail();
            $book->update($request->all());
            return response()->json([
                'success' => true,
                'msg' => 'Book updated successfully.',
                'book' => $book,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating book: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while updating the book.',
            ], 500);
        }
    }

    public function destroy(string $uuid)
    {
        try {
            $book = Book::where('book_id', $uuid)->firstOrFail();
            $book->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Book deleted successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting book: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while deleting the book.',
            ], 500);
        }
    }
}
