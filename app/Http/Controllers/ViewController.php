<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    private DataController $dataController;

    public function __construct(DataController $dataController)
    {
        $this->dataController = $dataController;
    }

    // Home function
    public function home()
    {
        $books = Book::all(); // Fetch all books
        $categories = Category::all(); // Fetch all categories
        $mostBorrowedBooks = $this->dataController->mostBorrowedBooks();
        $mostActiveUsers = $this->dataController->mostActiveUsers();
        $popularAuthors = $this->dataController->popularAuthors();

        return view("public.home", compact(
            "books",
            "categories",
            "mostBorrowedBooks",
            "mostActiveUsers",
            "popularAuthors"
        ));
    }

    // Book detail function
    public function book_detail($title)
    {
        $book = Book::where('title', $title)->firstOrFail();
        return view("public.book", compact('book'));
    }

    // Categories function
    public function categories()
    {
        $categories = Category::all(); // Fetch all categories
        return view("public.categories", compact('categories'));
    }

    public function category_detail($name)
    {
        $category = Category::where('name', $name)->firstOrFail(); // Fetch category by name
        $books = $category->books; // Get books related to this category

        return view("public.category", compact('category', 'books'));
    }


    // Search function
    public function search(Request $request)
    {
        $query = $request->input('q');
        $books = Book::where('title', 'like', "%{$query}%")
            ->orWhere('writer', 'like', "%{$query}%")
            ->get();

        return view('public.search', compact('books', "query"));
    }

}
