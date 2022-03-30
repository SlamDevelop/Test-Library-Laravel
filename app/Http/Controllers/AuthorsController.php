<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authors;

class AuthorsController extends Controller
{
    public function get(Authors $authors = null)
    {
        return $authors ? $authors : Authors::all();
    }

    public function create(Request $request)
    {
        $authors = Authors::create($request->all());

        return response()->json($authors);
    }

    public function update(Request $request, Authors $authors)
    {
        $authors->update($request->all());

        return response()->json($authors);
    }

    public function delete(Authors $authors)
    {
        $authors->delete();

        return response()->json(null);
    }
}
