@extends('layouts.layout')

@section('content')
    @if(count($comments) == 0)
        <h1>Здесь пока пусто</h1>
    @else
        @foreach($comments as $comment)
            @if(!$comment->deleted_at)
                <h2>{{ $comment->title }}</h2>
                <h3 class="comment-text">{{ $comment->text }}</h3>
                <h2>Получатель: <a href="{{ route('Profile', $comment->receiver_id) }}">{{ $comment->receiver->email }}</a></h2>
                <a href="{{ route('DeleteComment', $comment->id) }}">Удалить</a>
                <hr>
            @endif
        @endforeach
        <div class="users-pagination">{{ $comments->links('vendor.pagination.bootstrap-4') }}</div>
    @endif
@endsection
