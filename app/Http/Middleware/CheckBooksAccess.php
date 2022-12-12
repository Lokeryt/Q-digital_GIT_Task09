<?php

namespace App\Http\Middleware;

use App\Models\Book;
use App\Models\User;
use App\Models\UserLibraryAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class CheckBooksAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $book = Book::findOrFail($request->id);

        $owner = User::findOrFail($book->user_id);

        if ($request->code) {
            return $request->code == $book->code ? $next($request) : abort(403);
        } elseif (!Auth::check()) {
            abort(403);
        }

        if (Auth::id() == $owner->id || Auth::user()->hasLibraryAccess($owner)) {
            return $next($request);
        }

        abort(403);
    }
}
