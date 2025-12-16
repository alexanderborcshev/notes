<?php
namespace App\Infrastructure\Notes\Eloquent;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Note extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    protected $fillable = ['title', 'description'];
}
