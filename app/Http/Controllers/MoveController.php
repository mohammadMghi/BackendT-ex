<?php

namespace App\Http\Controllers;

use App\Models\Move;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    public function list(){
        return Move::all();
    }

    public function find($id){
        $move = Move::where('id' , $id)->get();
        if($move->count() > 0){
            return $move;
        }
        return response()->json(['response' => 'چیزی پیدا نشد'], 404); 
    }
}
