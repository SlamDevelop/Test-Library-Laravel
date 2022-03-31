<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Books;
use App\Models\Authors;
use App\Models\BooksAuthor;
use App\Models\Publishers;
use App\Models\PublishersBook;

class BooksController extends Controller
{
    public function get(Request $request, Books $books = null)
    {
        return $books ? $books : Books::all();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|string',
            'name' => 'required|string',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|string',
        ]);
         
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Checking the token
        $publisher = Publishers::where('api_token', $request->api_token)->first();
        if(!$publisher) {
            return response()->json(['error' => 'API Token incorrect'], 401);
        }
        // Adding publisher identifier to $request for easy API closure implementation by token
        // The code previously used the identifier through $request, so not to change the previous logic, I will use this option
        $request->publisher_id = $publisher->id;


        // Checking for the exist of a book
        $books = Books::where('name', $request->name)->first();
        if(!$books) {
            // Create book
            $books = Books::create([
                'name' => $request->name
            ]);

            // Handling book parameters
            $this->handleBook($books, $request);
        } else {
            // Checking for the existence of link to publisher in the publishers_books table
            // Created, if not, else the message of the exist
            $publishers = $books->publishers->where('id', $request->publisher_id)->first();
            if(!$publishers) {
                // Handling book parameters
                $this->handleBook($books, $request);
            } else {
                return response()->json(['error' => 'The book already exists'], 200);
            }
        }

        return response()->json(true, 201);
    }

    public function update(Request $request, Books $books)
    {
        // $books->update($request->all());
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Checking the token
        $publisher = Publishers::where('api_token', $request->api_token)->first();
        if(!$publisher) {
            return response()->json(['error' => 'API Token incorrect'], 401);
        }
        // Adding publisher identifier to $request for easy API closure implementation by token
        // The code previously used the identifier through $request, so not to change the previous logic, I will use this option
        $request->publisher_id = $publisher->id;

        // Checking the availability of the book in the library with the publisher
        // If yes, update the book, otherwise an error will occur
        $publishers = $books->publishers->where('id', $request->publisher_id)->first();
        if($publishers) {
            // If there exists a book name, update it
            if(!empty($request->name)) {
                $books->name = $request->name;
                $books->save();
            }

            // Handling book parameters
            $this->handleBook($books, $request);
        } else {
            return response()->json(['error' => 'The book is not in your library'], 200);
        }

        return response()->json(true, 200);
    }

    public function delete(Request $request, Books $books)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Checking the token
        $publisher = Publishers::where('api_token', $request->api_token)->first();
        if(!$publisher) {
            return response()->json(['error' => 'API Token incorrect'], 401);
        }
        // Adding publisher identifier to $request for easy API closure implementation by token
        // The code previously used the identifier through $request, so not to change the previous logic, I will use this option
        $request->publisher_id = $publisher->id;

        // Checking the availability of the book in the library with the publisher
        // If yes, removing all links related to the publisher, else an error will occur
        $publishers = $books->publishers->where('id', $request->publisher_id)->first();
        if($publishers) {
            $books->publishers_book->where('publishers_id', $request->publisher_id)
                ->first()
                ->delete();

            // If the author has no more books, deleting the author
            $books->authors->each(function($author) {
                if($author->books->count() <= 1) {
                    $author->delete();
                }
            });

            // If a book no longer has publishers, then deleting the book itself + authors and links to them
            if($books->publishers->count() <= 1) {
                $books->books_author->each(function($book_author) {
                    $book_author->delete();
                });
                $books->delete();
            }
        } else {
            return response()->json(['error' => 'The book is not in your library'], 200);
        }

        return response()->json(true, 200);
    }

    private function handleBook($book, $data)
    {
        // Handling authors
        // The check is necessary because there may not be an array of authors in @update
        if(!empty($data->authors) && is_array($data->authors)) {
            // First we remove the author for future correction
            $book->authors->each(function($author) {
                if($author->books->count() <= 1) {
                    $author->delete();
                }
            });
            $book->books_author->each(function($book_author) {
                $book_author->delete();
            });

            // Creating an updated list of authors of the book
            foreach($data->authors as $author_name) {
                $author = Authors::where('name', $author_name)->first();
                // Create if it doesn`t exist
                if(!$author) {
                    $author = Authors::updateOrCreate(
                        ['name' => $author_name]
                    );
                }
                // Creating links to authors in the intermediate table books_authors
                $book_author = new BooksAuthor;
                $book->books_author()->updateOrCreate(
                    ['authors_id' => $author->id]
                );
            }
        }

        // Creating link to publisher in the intermediate table publishers_books
        $book->publishers_book()->updateOrCreate(
            ['publishers_id' => $data->publisher_id]
        );
    }
}
