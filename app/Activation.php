<?php

namespace App;

use App\User;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    protected $guarded = ["id"];

    public function user() {
        return $this->belongsTo(User::class);
    }


    public function product() {
        return $this->belongsTo(product::class);
    }
}
