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

        $mostBorrowedUsers = Record::selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $mostBorrowedBooks = Record::selectRaw('book_id, COUNT(*) as total')
            ->groupBy('book_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $booksPerRack = Book::selectRaw('rack_id, COUNT(*) as total')
            ->groupBy('rack_id')
            ->get();

        $booksPerCategory = Book::selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->get();

        return view('admin.dashboard', compact(
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
        return view('admin.monitor', compact('records'));
    }
}

