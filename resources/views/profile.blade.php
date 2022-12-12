@extends('layouts.layout')

@section('content')
    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="profile-owner">{{ $user->email }}</h1>
        <hr>
        <div class="comments">
            @include('comments', ['comments' => $comments])
        </div>
        @can('write-comment', $user->id)
            <form class="create-comment-form" action="{{ route('WriteComment', $user->id) }}" method="POST">
                @csrf
                <input class="input-title" type="text" name="title" placeholder="Заголовок" required>
                <textarea class="input-text" type="text" name="text" placeholder="Текст" required></textarea>
                <button class="create-button" type="submit">Написать комментарий</button>
            </form>
        @endcan
    </div>
@endsection
