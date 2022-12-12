<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLibraryAccess extends Model
{
    use HasFactory;

    protected $table = 'user_libraries_access';

    protected $fillable = [
        'id',
        'owner_id',
        'user_id',
    ];

    public function checkAccess(User $owner, User $user)
    {
        return self::where('owner_id', $owner->id)
            ->where('user_id', $user->id)
            ->first();
    }
}
