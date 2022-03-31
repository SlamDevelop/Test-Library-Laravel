<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishersBook extends Model
{
    protected $fillable = ['publishers_id', 'books_id'];
}
