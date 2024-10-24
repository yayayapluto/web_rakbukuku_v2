@extends("layouts.public")
@section('title', 'Profile')

@section("content")
    <p>Hello <strong>{{$user->name}}</strong></p>
    <p>Your email is <strong>{{$user->email}}</strong></p>
    <p>Gender <strong>{{$user->gender ?? "not set"}}</strong></p>
    <p>Your phone number is <strong>{{$user->phone_number ?? "not set"}}</strong></p>
    <a href="{{route("logout")}}">logout</a>
@endsection'
