<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Rack;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['rack', 'category'])->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        // Assuming you have a method to get racks and categories
        $racks = Rack::all();
        $categories = Category::all();
        return view('books.create', compact('racks', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|uuid|unique:books,book_id',
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
            $validator->validate();
            Book::create([
                'book_id' => $request->book_id,
                'rack_id' => $request->rack_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'isbn' => $request->isbn,
                'writer' => $request->writer,
                'publisher' => $request->publisher,
                'publish_year' => $request->publish_year,
                'cover' => $request->cover,
                'soft_file' => $request->soft_file,
                'stock' => $request->stock,
            ]);
            return Redirect::route('books.index')->with('success', 'Book created successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while creating the book.']);
        }
    }

    public function show(string $id)
    {
        $book = Book::with(['rack', 'category'])->findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $racks = Rack::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'racks', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'rack_id' => 'required|uuid|exists:racks,rack_id',
            'category_id' => 'required|uuid|exists:categories,category_id',
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publish_year' => 'required|integer',
            'cover' => 'nullable|url',
            'soft_file' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            $validator->validate();
            $book = Book::findOrFail($id);
            $book->update([
                'rack_id' => $request->rack_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'isbn' => $request->isbn,
                'writer' => $request->writer,
                'publisher' => $request->publisher,
                'publish_year' => $request->publish_year,
                'cover' => $request->cover,
                'soft_file' => $request->soft_file,
                'stock' => $request->stock,
            ]);
            return Redirect::route('books.index')->with('success', 'Book updated successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while updating the book.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            Book::destroy($id);
            return Redirect::route('books.index')->with('success', 'Book deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while deleting the book.']);
        }
    }
}
