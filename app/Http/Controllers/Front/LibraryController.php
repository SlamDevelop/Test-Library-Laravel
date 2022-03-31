<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;

class LibraryController extends Controller
{
    public function index() 
    {
        $books = Books::all();
        return view('library', compact('books'));
    }
}