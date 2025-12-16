<?php
namespace App\Infrastructure\Notes\Eloquent;

use Database\Factories\Infrastructure\Notes\Eloquent\NoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Note extends Model
{
    /** @use HasFactory<NoteFactory> */
    use HasFactory;
    protected $fillable = ['title', 'description'];
}
