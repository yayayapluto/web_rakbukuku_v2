<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Redirect;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::with(['user', 'book'])->get();
        return view('records.index', compact('records'));
    }

    public function create()
    {
        $users = User::all();
        $books = Book::all();
        return view('records.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'record_id' => 'required|uuid|unique:records,record_id',
            'user_id' => 'required|uuid|exists:users,user_id',
            'book_id' => 'required|uuid|exists:books,book_id',
            'status' => 'required|in:borrow,return',
            'borrow_date' => 'nullable|date',
            'return_date' => 'nullable|date',
        ]);

        try {
            $validator->validate();
            Record::create([
                'record_id' => $request->record_id,
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'status' => $request->status,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
            ]);
            return Redirect::route('records.index')->with('success', 'Record created successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while creating the record.']);
        }
    }

    public function show(string $id)
    {
        $record = Record::with(['user', 'book'])->findOrFail($id);
        return view('records.show', compact('record'));
    }

    public function edit(string $id)
    {
        $record = Record::findOrFail($id);
        $users = User::all();
        $books = Book::all();
        return view('records.edit', compact('record', 'users', 'books'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid|exists:users,user_id',
            'book_id' => 'required|uuid|exists:books,book_id',
            'status' => 'required|in:borrow,return',
            'borrow_date' => 'nullable|date',
            'return_date' => 'nullable|date',
        ]);

        try {
            $validator->validate();
            $record = Record::findOrFail($id);
            $record->update([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'status' => $request->status,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
            ]);
            return Redirect::route('records.index')->with('success', 'Record updated successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while updating the record.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            Record::destroy($id);
            return Redirect::route('records.index')->with('success', 'Record deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'An error occurred while deleting the record.']);
        }
    }
}
