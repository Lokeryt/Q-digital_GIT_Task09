@extends('layouts.layout')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('Success'))
        <h2>{{ session('Success') }}</h2>
    @endif
    @if($books->count() == 0)
        <h1>Здесь пока пусто</h1>
    @else
        @foreach($books as $book)
            <h1>{{ $book->title }}</h1>
            @can('delete-edit-book', $book)
                <a class="comment-button" href="{{ route('DeleteBook', $book->id) }}">Удалить</a>
                <a class="comment-button js-open-modal" data-id="{{ $book->id }}" href="#">Изменить</a>
                <div class="modal-overlay not-active" data-id="{{ $book->id }}">
                    <svg class="modal-cross" data-id="{{ $book->id }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>
                    <form class="reply-comment-form" action="{{ route('EditBook', $book->id) }}" method="POST">
                        @csrf
                        <input class="input-title" type="text" name="title" placeholder="Заголовок" value="{{ $book->title }}" required>
                        <textarea class="input-text" type="text" name="text" placeholder="Текст" required>{{ $book->text }}</textarea>
                        <button class="create-button" type="submit">Изменить</button>
                    </form>
                </div>
                <a class="comment-button" href="{{ route('ShareBook', $book->id) }}">Поделиться</a>
            @endcan
            <a class="comment-button" href="{{ route('Book', $book->id) }}">Открыть</a>
            <hr>
        @endforeach
        <div class="users-pagination">{{ $books->links('vendor.pagination.bootstrap-4') }}</div>
    @endif
    @can('create-book', $owner)
        <form class="create-comment-form" action="{{ route('CreateBook', $owner->id) }}" method="POST">
            @csrf
            <input class="input-title" type="text" name="title" placeholder="Заголовок" required>
            <textarea class="input-text" type="text" name="text" placeholder="Текст" required></textarea>
            <button class="create-button" type="submit">Добавить книгу</button>
        </form>
    @endcan
@endsection
