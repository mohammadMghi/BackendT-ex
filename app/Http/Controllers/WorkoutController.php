<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function find($workout_id){
       $packages = Package::where('id' , $workout_id)->with('moves.duration')->get();
       if($packages->count() > 0){
            return $packages;
       }
       return response()->json(['response' => 'چیزی پیدا نشد'], 404); 
    }
}
