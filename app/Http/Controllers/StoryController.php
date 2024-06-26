<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    public function create(Request $request) {

        $validate = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date_start' => 'required|date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan",
                'data' => $validate->errors(),
            ]);
        }

        try {
            $story = new Story();
            $story->title = $request->title;
            $story->description =  $request->description; 
            $story->location =  $request->location;
            $story->date_start = $request->date_start; 
            $story->date_finish =   isset($request->date_finish) && !is_null($request->date_finish) ? $request->date_finish : null;
            $story->save();

            if (!empty($request->events)) {
                foreach ($request->events as $key => $val) {
                    $event = new Events();
                    $event->story_id = $story->id;
                    $event->title = $val['title'];
                    $event->content = $val['content'];
                    $event->sequence = $key;
                    $event->save();
                }
            }

            $data = Story::with('events')->find($story->id);
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

    public function delete(Request $request) {
        $validate = Validator::make($request->all(),[
            'id' => 'required|integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan",
                'data' => $validate->errors(),
            ]);
        }

        try {
            $story = Story::find($request->id);
            $story->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil dihapus",
                'data' => $story
            ], 200);
            
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan",
                'data' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request) {
        $validate = Validator::make($request->all(),[
            'id' => 'required|integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan",
                'data' => $validate->errors(),
            ]);
        }

        $data = $request->all();
        
        try {
            Story::where('id',$request->id)->update($data);
            return response()->json([
                'success' => true,
                'message' => "Berhasil diupdate",
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

    public function get_story(Request $request, $id=null) {
        //cek apakah parameter id
        if ($id) {
            $story = Story::find($id);
            if (!$story) {
                return response()->json([
                    'success' => false,
                    'message' => "Data tidak ditemukan",
                    'data' => [],
                ],400);
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil",
                'data' => $story,
            ]);
        }
        else {
            $sort_by = isset($request->sort_by) ? $request->sort_by : null;
            $limit = isset($request->limit) ? $request->limit : 6;
            $page = isset($request->page) ? $request->page : 1;
            $offset = ($page - 1) * $limit;

            $story = array();

            if ($sort_by) {
                $sort_field = explode(':',$request->sort_by)[0];
                $sort_order = explode(':',$request->sort_by)[1];

                $story = Story::orderBy($sort_field, $sort_order)->take($limit)->offset($offset)->get();
            } else {
                $story = Story::take($limit)->offset($offset)->get();
            }

            if (!$story) {
                return response()->json([
                    'success' => false,
                    'message' => "Data tidak ditemukan",
                    'data' => [],
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil",
                'data' => $story,
            ]);
        }
    }
    public function get_latest_story() {
        $story = Story::orderByDesc('created_at')->take('3')->get();

        return response()->json([
            'success' => true,
            'message' => "Berhasil",
            'data' => $story,
        ]);
    }

    public function get_popular_story() {
        // Batasi 3 story
    }

    public function find_story() {
        //Cari berdasarkan title
    }

    public function finish_read(Request $request) {

    }
    public function has_read(Request $request) {

    }

    private function add_to_history() {

    }

    private function add_user_point() {

    }

    public function add_to_series() {

    }

}
