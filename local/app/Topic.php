<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function subject()
    {
    	return $this->belongsTo('App\Subject');
    }

   

    /**
     * Get the list of topics from selected topic
     * @param  [type]  $subject_id [description]
     * @param  integer $parent_id  [description]
     * @return [type]              [description]
     */
    public static function getTopics($subject_id, $parent_id = 0)
    {
    	return Topic::where('parent_id', '=', $parent_id)
    			->where('subject_id', '=', $subject_id)
    			->get();
    }

    /**
     * This method returns the list of questions available for the selected topic
     * @return [type] [description]
     */
    public function getQuestions()
    {
        return $this->hasMany('App\QuestionBank','topic_id');
    }
}
