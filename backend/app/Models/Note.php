<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'created_at',
    ];
}
