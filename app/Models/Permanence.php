<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permanence extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the user that owns the permanence.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
