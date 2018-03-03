<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
 
 
    public static function getRecordWithSlug($slug)
    {
        return Feedback::where('slug', '=', $slug)->first();
    }
}
