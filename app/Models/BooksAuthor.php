<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksAuthor extends Model
{
    protected $fillable = ['book_id', 'author_id'];
}
