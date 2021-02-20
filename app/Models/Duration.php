<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;
    protected $table = "duration";

    public function move(){
        return $this->belongsTo(move::class,'package_move');
    }

    protected $visible = ['duration'];
}
