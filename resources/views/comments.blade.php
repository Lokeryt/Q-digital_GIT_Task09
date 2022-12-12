@if($count == 0)
    <h1>Здесь пока пусто</h1>
@else
    @foreach($comments as $comment)
        <li>
            @if($comment->deleted_at)
                <h1>Комментарий удалён</h1>
            @else
                <h2>{{ $comment->title }}</h2>
                <h3 class="comment-text">{{ $comment->text }}</h3>
                <h2>Отправитель: <a href="{{ route('Profile', $comment->sender_id) }}">{{ $comment->sender->email }}</a></h2>
                @can('delete-comment', $comment)
                    <a class="comment-button" href="{{ route('DeleteComment', $comment->id) }}">Удалить</a>
                @endcan
                @can('reply-comment', $comment)
                    <a class="comment-button js-open-modal" data-id="{{ $comment->id }}" href="#">Ответить</a>
                    <div class="modal-overlay not-active" data-id="{{ $comment->id }}">
                        <svg class="modal-cross" data-id="{{ $comment->id }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>
                        <p>Ответ {{ $comment->sender->email }}</p>
                        <form class="reply-comment-form" action="{{ route('WriteComment', $user->id) }}" method="POST">
                            @csrf
                            <input class="input-title" type="text" name="title" placeholder="Заголовок" required>
                            <textarea class="input-text" type="text" name="text" placeholder="Текст" required></textarea>
                            <input name="parent_id" hidden value="{{ $comment->id }}">
                            <button class="create-button" type="submit">Ответить</button>
                        </form>
                    </div>
                @endcan
            @endif
            @if($comment->children()->count() > 0)
                <h2>&#9660;</h2>
                <ul>
                    @include('comments', ['comments' => $comment->children(), 'children' => true])
                </ul>
            @endif
        </li>
        <hr>
    @endforeach
    @if($count > 5 && empty($children))
        <button class="show-all" data-id="{{ $user->id }}">Показать все</button>
    @endif
@endif
