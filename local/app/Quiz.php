<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QuestionBank;
use DB;

class Quiz extends Model
{
    protected $table= "quizzes";

  

    public static function getRecordWithSlug($slug)
    {
        return Quiz::where('slug', '=', $slug)->first();
    }
    
    /**
     * Returns the category name for the selected quiz
     * @return [type] [description]
     */
    public function category()
    {
        return $this->belongsTo('App\QuizCategory');
    }

    /**
     * This method returns the set of questions available for the sent quiz id
     * @return [type] [description]
     */
    public function getQuestions()
    {
         return DB::table('questionbank_quizzes')
                     ->where('quize_id','=',$this->id)
                     ->orderBy('subject_id')
                     ->get();
    }

    public function prepareQuestions($questions)
    {
         $final_questions = array();
        $final_subjects = array();
        foreach($questions as $r)
        {
            $temp_question = array();
            $temp_subject = array();
            $temp_question       = QuestionBank::find($r->questionbank_id);

            $temp_subject        = Subject::find($r->subject_id);
            
            array_push($final_questions, $temp_question);
            if(!$this->compareSubjects($final_subjects, $temp_subject))
                array_push($final_subjects, $temp_subject);
            
            // $final_subjects->unique();
        }

        return  array('questions' => $final_questions, 
                      'subjects' => $final_subjects
                     );
    }

       /**
     * Compares the subjects and returns the is unique or not
     * @param  [type] $final_subjects [array]
     * @param  [type] $temp_subject   [array]
     * @return [type]                 [boolen]
     */
    public function compareSubjects($final_subjects, $temp_subject)
    {
        $flag = 0;
        foreach($final_subjects as $sub)
        {
            if($sub->id == $temp_subject->id){
                $flag=1; break;
            }
        }
        return $flag;
    }

}
