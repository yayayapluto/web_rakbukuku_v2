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
        return view('private.records.index', compact('records'));
    }

    public function show(string $uuid)
    {
        $record = Record::with(['user', 'book'])->where('record_id', $uuid)->firstOrFail();
        return view('private.records.show', compact('record'));
    }

    public function destroy(string $uuid)
    {
        try {
            $record = Record::where('record_id', $uuid)->firstOrFail();
            $record->delete();
            return response()->json(['success' => true, 'msg' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'An error occurred while deleting the record.'], 500);
        }
    }

}
