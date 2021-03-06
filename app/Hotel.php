<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class Hotel extends Model
{
    use SoftDeletes;
 
    protected $dates = ['deleted_at'];

    protected $guarded = ["id"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

