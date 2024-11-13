<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Record;
use Auth;
use Illuminate\Http\Request;

class   ViewController extends Controller
{
    private DataController $dataController;

    public function __construct(DataController $dataController)
    {
        $this->dataController = $dataController;
    }

    // Home function
    public function home()
    {
        $books = Book::limit(7)->get(); // Fetch all books
        $categories = Category::inRandomOrder()->limit(7)->get(); // Fetch all categories
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
        $book = Book::where('title', $title)->firstOrFail();  // Get the book by title

        // If the user is logged in, get their borrowing record for this book
        if (Auth::check()) {
            $record = Record::where("book_id", $book->book_id)
                ->where("user_id", Auth::user()->user_id)
                ->latest()
                ->first();  // Get the first matching record, or null if not found
            return view("public.book", compact('book', "record"));
        }

        // If the user is not logged in, just pass the book details
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
        $categories = Category::all();

        return view("public.category", compact('category', 'books', 'categories'));
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
