<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function getUsers()
    {
        return self::where('id', '!=', Auth::id())->orderBy('id');
    }

    public function receivedComments()
    {
        return $this->hasMany(Comment::class, 'receiver_id', 'id');
    }

    public function sentComments()
    {
        return $this->hasMany(Comment::class, 'sender_id', 'id');
    }

    public function ownedBooks()
    {
        return $this->hasMany(Book::class, 'user_id', 'id');
    }

    public function hasLibraryAccess($owner)
    {
        $access = new UserLibraryAccess();

        return $access->checkAccess($owner, $this);
    }
}
