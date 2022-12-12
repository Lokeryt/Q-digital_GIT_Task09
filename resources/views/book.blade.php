@extends('layouts.layout')

@section('content')
    <h1>{{ $book->title }}</h1>
    <p>{{ $book->text }}</p>
@endsection
