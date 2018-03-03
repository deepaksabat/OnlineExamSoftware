<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
     protected $table= "notifications";

 

    public static function getRecordWithSlug($slug)
    {
        return Notification::where('slug', '=', $slug)->first();
    }

}
