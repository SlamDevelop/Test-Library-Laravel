<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Books;
use App\Models\Authors;
use App\Models\BooksAuthor;
use App\Models\PublishersBook;

class BooksController extends Controller
{
    public function get(Books $books = null)
    {
        return $books ? $books : Books::all();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'api_token' => 'required|string',
            'publisher_id' => 'required|string',
            'name' => 'required|string',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|string',
        ]);
         
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Checking for the exist of a book
        $book = Books::where('name', $request['name'])->first();
        if(!$book) {
            // Create book
            $book = Books::create([
                'name' => $request->name
            ]);

            // Handling authors
            foreach($request->authors as $author_name) {
                $author = Authors::where('name', $author_name)->first();
                // Create if it doesn`t exist
                if(!$author) {
                    $author = Authors::create([
                        'name' => $author_name
                    ]);
                }
                // Creating links to authors in the intermediate table books_authors
                $book_author = new BooksAuthor;
                $book_author->authors_id = $author->id;
                $book->authors_ids()->save($book_author);
            }

            // Creating link to publisher in the intermediate table publishers_books
            $publishers_book = new PublishersBook;
            $publishers_book->publishers_id = $request->publisher_id;
            $book->publishers_ids()->save($publishers_book);
        } else {
            // Checking for the existence of link to publisher in the publishers_books table
            // Created, if not, else the message of the exist
            if(!$book->publishers_ids->where('publishers_id', $request->publisher_id)->first()) {
                // Creating link to publisher in the intermediate table publishers_books
                $publishers_book = new PublishersBook;
                $publishers_book->publishers_id = $request->publisher_id;
                $book->authors_ids()->save($publishers_book);
            } else {
                return response()->json(['error' => 'The book already exists'], 200);
            }
        }

        return response()->json(true, 201);
    }

    public function update(Request $request, Books $books)
    {
        $books->update($request->all());

        return response()->json($books);
    }

    public function delete(Request $request, Books $books)
    {
        $validator = Validator::make($request->all(), [
            'publisher_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Checking the availability of the book in the library with the publisher
        // If yes, removing all links related to the publisher, else an error will occur
        $publishers = $books->publishers->where('id', $request->publisher_id)->first();
        if($publishers) {
            $publishers_book = $books->publishers_ids->where('publishers_id', $request->publisher_id)->first();
            $publishers_book->delete();

            // If the author has no more books, deleting the author
            $books->authors->each(function($author) {
                if($author->books->count() <= 1) {
                    $author->delete();
                }
            });

            // If a book no longer has publishers, then deleting the book itself + authors and links to them
            if($books->publishers->count() <= 1) {
                $books->authors_ids->each(function($book_author) {
                    $book_author->delete();
                });
                $books->delete();
            }
        } else {
            return response()->json(['error' => 'The book is not in your library'], 200);
        }

        return response()->json(null, 200);
    }
}
