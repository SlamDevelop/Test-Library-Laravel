<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publishers;

class PublishersController extends Controller
{
    public function get(Publishers $publishers = null)
    {
        return $publishers ? $publishers : Publishers::all();
    }

    public function create(Request $request)
    {
        $publishers = Publishers::create($request->all());

        return response()->json($publishers);
    }

    public function update(Request $request, Publishers $publishers)
    {
        $publishers->update($request->all());

        return response()->json($publishers);
    }

    public function delete(Publishers $publishers)
    {
        $publishers->delete();

        return response()->json(null);
    }
}
