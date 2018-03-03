<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
class Subject extends Model
{
    
    public function topics()
    {
    	return $this->hasMany('App\Topic');
    }



    public function questions()
    {
        return $this->hasMany('App\QuestionBank');
    }

    public function course()
    {
    	return $this->belongsToMany('App\Course','course_subject','subject_id','academic_course_id')->withPivot('year','semister', 'sessions_needed')->withTimestamps();
    }

   

    public static function getRecordWithSlug($slug)
    {
        return Subject::where('slug', '=', $slug)->first();
    }

    public static function getName($subject_id)
    {
        return Subject::where('id',$subject_id)->first()->subject_title;
    }
}
