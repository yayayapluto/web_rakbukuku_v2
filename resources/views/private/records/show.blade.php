@extends('layouts.private')

@section('content')
    <h1>Record Details</h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            Record Information
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Record ID:</label>
                                <p>{{ $record->record_id }}</p>
                            </div>
                            <div class="form-group">
                                <label>Status:</label>
                                <p>{{ $record->status }}</p>
                            </div>
                            <div class="form-group">
                                <label>Borrow Date:</label>
                                <p>{{ $record->borrow_date }}</p>
                            </div>
                            <div class="form-group">
                                <label>Return Date:</label>
                                <p>{{ $record->return_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            User & Book Information
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>User:</label>
                                <p>{{ $record->user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>Book:</label>
                                <p>{{ $record->book->title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <a href="{{ route('records.index') }}" class="btn btn-secondary">Back to Records</a>
            <form action="{{ route('records.destroy', $record->record_id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete Record</button>
            </form>
        </div>
    </div>
@endsection
