<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasManyThrough(
            Books::class,
            BooksAuthor::class,
            'authors_id', // Foreign key on the books_author authors table
            'id', // Foreign key on the authors table
            'id', // Local key on the books table
            'books_id' // Local key on the books table
        );
    }

    public function books_ids()
    {
        return $this->hasMany(BooksAuthor::class);
    }
}
