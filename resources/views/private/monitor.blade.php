@extends("layouts.private")

@section("title", "Monitor")

@section("content")
    <h1>Monitor</h1>

    <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Status</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record->record_id }}</td>
                        <td>{{ $record->user->name }}</td>
                        <td>{{ $record->book->title }}</td>
                        <td>{{ $record->status }}</td>
                        <td>{{ $record->borrow_date }}</td>
                        <td>{{ $record->return_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
