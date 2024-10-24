<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Rack;
use App\Models\Record;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalRacks = Rack::count();
        $totalBooks = Book::count();
        $totalRecords = Record::count();

        // Chart data
        $recordStatusChart = Record::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // Most Borrowed Users
        $mostBorrowedUsers = Record::selectRaw('user_id, COUNT(*) as total')
            ->with('user') // Assuming the User model has a relationship defined
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get()
            ->map(function ($record) {
                return [
                    'user_name' => $record->user->name,
                    'total' => $record->total,
                ];
            });

        // Most Borrowed Books
        $mostBorrowedBooks = Record::selectRaw('book_id, COUNT(*) as total')
            ->with('book') // Assuming the Book model has a relationship defined
            ->groupBy('book_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get()
            ->map(function ($record) {
                return [
                    'book_name' => $record->book->title,
                    'total' => $record->total,
                ];
            });

        // Books per Rack
        $booksPerRack = Book::selectRaw('rack_id, COUNT(*) as total')
            ->with('rack') // Assuming the Rack model has a relationship defined
            ->groupBy('rack_id')
            ->get()
            ->map(function ($record) {
                return [
                    'rack_name' => $record->rack->name,
                    'total' => $record->total,
                ];
            });

        // Books per Category
        $booksPerCategory = Book::selectRaw('category_id, COUNT(*) as total')
            ->with('category') // Assuming the Category model has a relationship defined
            ->groupBy('category_id')
            ->get()
            ->map(function ($record) {
                return [
                    'category_name' => $record->category->name,
                    'total' => $record->total,
                ];
            });

        return view("private.dashboard", compact(
            'totalUsers',
            'totalRacks',
            'totalBooks',
            'totalRecords',
            'recordStatusChart',
            'mostBorrowedUsers',
            'mostBorrowedBooks',
            'booksPerRack',
            'booksPerCategory'
        ));
    }

    public function monitor()
    {
        $records = Record::with(['user', 'book'])->get();
        return view('private.monitor', compact('records'));
    }
}
