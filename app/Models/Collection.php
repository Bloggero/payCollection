<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;


    /**
     * Get the phone associated with the user.
     */
    public function username()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
