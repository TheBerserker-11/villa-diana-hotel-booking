<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';  // explicitly set table name

    protected $fillable = [
        'room_id',
        'user_name',
        'comment',
        'rating',
    ];
}
