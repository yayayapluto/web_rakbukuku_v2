<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserRecordController extends Controller
{
    public function showBorrowForm($bookId)
    {
        // Use where method to find the book by its UUID
        $book = Book::where('book_id', $bookId)->firstOrFail();
        return view("public.users.borrow", compact("book"));
    }

    public function showReturnForm($bookId)
    {
        $book = Book::where('book_id', $bookId)->firstOrFail();
        return view("public.users.return", compact("book"));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view("public.users.profile", compact("user"));
    }

    public function showHistory()
    {
        $user = Auth::user();
        $records = Record::with('book')->where('user_id', $user->user_id)->get();
        return view("public.users.history", compact("records"));
    }

    public function borrow(Request $request, $bookId)
    {
        try {
            $user = Auth::user();

            // Use where method to find the book by its UUID
            $book = Book::where('book_id', $bookId)->firstOrFail();

            // Check if book is out of stock
            if ($book->stock <= 0) {
                return response()->json([
                    'success' => false,
                    'msg' => 'This book is currently out of stock.',
                ]);
            }

            // Create a new borrowing record
            $record = new Record();
            $record->record_id = Str::uuid();
            $record->user_id = $user->user_id;
            $record->book_id = $book->book_id;
            $record->status = 'borrow';
            $record->borrow_date = now();
            $record->save();

            // Decrement the book stock
            $book->decrement('stock');

            return response()->json([
                'success' => true,
                'msg' => 'Book borrowed successfully!',
                'route' => route('user.profile'),  // You can return the route to redirect after success
            ]);
        } catch (\Exception $e) {
            // Catch any exception and return a failure message
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while borrowing the book.',
            ]);
        }
    }

    public function return(Request $request, $bookId)
    {
        try {
            $user = Auth::user();
            $book = Book::where('book_id', $bookId)->firstOrFail();

            // Check if the user has a borrow record for the book
            $record = Record::where('user_id', $user->user_id)
                ->where('book_id', $book->book_id)
                ->where('status', 'borrow')
                ->first();

            // If no borrow record exists, return an error
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'msg' => 'You have not borrowed this book or it has already been returned.',
                ]);
            }

            // Proceed with updating the record
            $record->status = 'return';
            $record->return_date = now();
            $record->save();

            // Increment the book stock
            $book->increment('stock');

            return response()->json([
                'success' => true,
                'msg' => 'Book returned successfully!',
                'route' => route('user.history'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while returning the book: ' . $e->getMessage(),
            ]);
        }
    }


}
