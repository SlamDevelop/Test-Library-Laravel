<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BooksController extends Controller
{
    public function get(Books $books = null)
    {
        return $books ? $books : Books::all();
    }

    public function create(Request $request)
    {
        $books = Books::create($request->all());

        return response()->json($books);
    }

    public function update(Request $request, Books $books)
    {
        $books->update($request->all());

        return response()->json($books);
    }

    public function delete(Books $books)
    {
        $books->delete();

        return response()->json(null, 200);
    }
}
