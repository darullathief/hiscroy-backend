<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeriesController extends Controller
{
    public function create(Request $request) {

        $validate = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'story' => 'required|array'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan",
                'data' => $validate->errors(),
            ]);
        }

        try {
            $series = new Series();
            $series->title = $request->title;
            $series->description =  $request->description; 
            $series->location =  $request->location;
            $series->save();
            $series->story()->sync($request->story);

            $data = $series::with(['story' => function($query) {
                $query->select('title');
            }])->find($series->id);

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan",
                'data' => $e->getMessage(),
            ]);
        }

    }

}
