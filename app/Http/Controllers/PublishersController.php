<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Publishers;

class PublishersController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
         
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Checking for the exist of a publisher
        $publishers = Publishers::where('name', $request->name)->first();
        if(!$publishers) {
            $publishers = Publishers::create([
                'name' => $request->name,
                'api_token' => Str::random(24)
            ]);
        } else {
            return response()->json(['error' => 'The publisher already exists'], 200);
        }

        return response()->json($publishers);
    }
}
