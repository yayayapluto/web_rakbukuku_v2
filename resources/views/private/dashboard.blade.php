@extends('layouts.private')

@section("title", "Dashboard")

@section("header")
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@section('content')
    <h1>Dashboard</h1>

    <div class="row mb-3">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">
                    Total Users
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">
                    Total Racks
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalRacks }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">
                    Total Books
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalBooks }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">
                    Total Records
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalRecords }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    Record Status Distribution
                </div>
                <div class="card-body">
                    <div id="recordStatusChart"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    Most Borrowed Users
                </div>
                <div class="card-body">
                    <div id="mostBorrowedUsersChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    Most Borrowed Books
                </div>
                <div class="card-body">
                    <div id="mostBorrowedBooksChart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    Total Books Per Rack
                </div>
                <div class="card-body">
                    <div id="booksPerRackChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    Total Books Per Category
                </div>
                <div class="card-body">
                    <div id="booksPerCategoryChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
<script>
        // Record Status Chart
        var recordStatusOptions = {
            chart: {
                type: 'pie'
            },
            series: @json($recordStatusChart->pluck('total')),
            labels: @json($recordStatusChart->pluck('status')),
            title: {
                text: 'Record Status Distribution'
            }
        }
        var recordStatusChart = new ApexCharts(document.querySelector("#recordStatusChart"), recordStatusOptions);
        recordStatusChart.render();

        // Most Borrowed Users Chart
        var mostBorrowedUsersOptions = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Borrowed',
                data: @json($mostBorrowedUsers->pluck('total')),
            }],
            xaxis: {
                categories: @json($mostBorrowedUsers->pluck('user_name')),
                title: {
                    text: 'Users'
                }
            },
            title: {
                text: 'Most Borrowed Users'
            }
        }
        var mostBorrowedUsersChart = new ApexCharts(document.querySelector("#mostBorrowedUsersChart"), mostBorrowedUsersOptions);
        mostBorrowedUsersChart.render();

        // Most Borrowed Books Chart
        var mostBorrowedBooksOptions = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Borrowed',
                data: @json($mostBorrowedBooks->pluck('total')),
            }],
            xaxis: {
                categories: @json($mostBorrowedBooks->pluck('book_name')),
                title: {
                    text: 'Books'
                }
            },
            title: {
                text: 'Most Borrowed Books'
            }
        }
        var mostBorrowedBooksChart = new ApexCharts(document.querySelector("#mostBorrowedBooksChart"), mostBorrowedBooksOptions);
        mostBorrowedBooksChart.render();

        // Books Per Rack Chart
        var booksPerRackOptions = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Books',
                data: @json($booksPerRack->pluck('total')),
            }],
            xaxis: {
                categories: @json($booksPerRack->pluck('rack_name')),
                title: {
                    text: 'Racks'
                }
            },
            title: {
                text: 'Total Books Per Rack'
            }
        }
        var booksPerRackChart = new ApexCharts(document.querySelector("#booksPerRackChart"), booksPerRackOptions);
        booksPerRackChart.render();

        // Books Per Category Chart
        var booksPerCategoryOptions = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Books',
                data: @json($booksPerCategory->pluck('total')),
            }],
            xaxis: {
                categories: @json($booksPerCategory->pluck('category_name')),
                title: {
                    text: 'Categories'
                }
            },
            title: {
                text: 'Total Books Per Category'
            }
        }
        var booksPerCategoryChart = new ApexCharts(document.querySelector("#booksPerCategoryChart"), booksPerCategoryOptions);
        booksPerCategoryChart.render();
    </script>
@endsection
