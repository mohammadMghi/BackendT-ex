<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    public function packages(){
        return $this->belongsToMany(Package::class );
    }

    public function duration(){
        return $this->hasOne(Duration::class);
    }


}
