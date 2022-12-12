@extends('layouts.layout')

@section('content')
    @if(count($users) == 0)
        <h1>Здесь пока пусто</h1>
    @else
        @foreach($users as $user)
            <div class="users-block">
                <div class="user-block">
                    <h4><a href="{{ route('Profile', $user->id) }}">{{ $user->email }}</a></h4>
                </div>
            </div>
        @endforeach
        <div class="users-pagination">{{ $users->links('vendor.pagination.bootstrap-4') }}</div>
    @endif
@endsection
