<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = ['name'];

    public function authors()
    {
        return $this->hasManyThrough(
            Authors::class,
            BooksAuthor::class,
            'books_id', // Foreign key on the books_author authors table
            'id', // Foreign key on the authors table
            'id', // Local key on the books table
            'authors_id' // Local key on the authors table
        );
    }

    public function books_author()
    {
        return $this->hasMany(BooksAuthor::class);
    }

    public function publishers()
    {
        return $this->hasManyThrough(
            Publishers::class,
            PublishersBook::class,
            'books_id', // Foreign key on the publishers_books authors table
            'id', // Foreign key on the publishers table
            'id', // Local key on the books table
            'publishers_id' // Local key on the publishers table
        );
    }

    public function publishers_book()
    {
        return $this->hasMany(PublishersBook::class);
    }
}
