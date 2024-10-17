<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Record;

class DataController extends Controller
{
    // Most borrowed books
    public function mostBorrowedBooks()
    {
        return Book::select('books.*')
            ->join('records', 'books.book_id', '=', 'records.book_id')
            ->selectRaw('count(records.book_id) as borrow_count')
            ->groupBy('books.book_id')
            ->orderBy('borrow_count', 'desc')
            ->take(10)
            ->get();
    }

    // Most active users
    public function mostActiveUsers()
    {
        return User::select('users.*')
            ->join('records', 'users.user_id', '=', 'records.user_id')
            ->selectRaw('count(records.user_id) as borrow_count')
            ->groupBy('users.user_id')
            ->orderBy('borrow_count', 'desc')
            ->take(10)
            ->get();
    }

    // Popular authors
    public function popularAuthors()
    {
        return Book::select('writer')
            ->selectRaw('count(records.book_id) as borrow_count')
            ->join('records', 'books.book_id', '=', 'records.book_id')
            ->groupBy('writer')
            ->orderBy('borrow_count', 'desc')
            ->take(10) // Limit to top 10 authors
            ->get();
    }
}
