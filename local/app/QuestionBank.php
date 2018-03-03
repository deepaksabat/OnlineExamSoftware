<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use \App;
use App\Bookmark;
use Auth;
Use App\Subject;
use App\Topic;
class QuestionBank extends Model
{
    protected $table = 'questionbank';
    public $success_list   = [];
    public $failed_list    = [];
    public $excelRecords   = [];
    public $questionType   = '';
    public $columns_list   = [];
 

	public function subject()
	{
		return $this->belongsTo('App\Subject');
	}

    public function isBookmarked($question_id, $type ='all')
    {
        $records = Bookmark::where('user_id', '=', Auth::user()->id)
                        ->where('item_id', '=', $question_id)
                        ->where('item_type', '=', 'questions');
        if($type=='all')
            return $records;
        return count($records);

    }
	public static function getRecordWithSlug($slug)
    {
        return QuestionBank::where('slug', '=', $slug)->first();
    }

    /**
     * Check if the specific question exists in any quizzes
     * If exists return true else return false
     * @param  [type] $question_id [description]
     * @return [type]              [description]
     */
    public function questionExistsQuizzes($question_id)
    {
    	$quizzes = DB::table('questionbank_quizzes')
    	->select('id')
    	->where('questionbank_id','=',$question_id)->get();
    	return count($quizzes) ? TRUE : FALSE ;
    }

    /**
     * Thid method uploads the Radio type of question
     * Before It will validate all the records
     * @param  [type] $records [description]
     * @return [type]          [description]
     */
    public function uploadRadioQuestions($records)
    {
        $this->excelRecords = $records;
        $this->questionType = 'radio';
        $recordsHavingIssues = FALSE;        
        if(!$this->validateQuestions())
            $recordsHavingIssues = TRUE;
        if(!$this->prepareAndPushRadioQuestions())
            $recordsHavingIssues = TRUE;
       
        return $recordsHavingIssues;
       
        
    }

    /**
     * This method uploads checkbox questions
     * @param  [type] $records [description]
     * @return [type]          [description]
     */
    public function uploadCheckboxQuestions($records)
    {
        $this->excelRecords = $records;
        $this->questionType = 'checkbox';
        $recordsHavingIssues = FALSE;        
        if(!$this->validateQuestions())
            $recordsHavingIssues = TRUE;
        if(!$this->prepareAndPushCheckboxQuestions())
            $recordsHavingIssues = TRUE;
       
        return $recordsHavingIssues;
    }
    /**
     * This method uploads blank questions
     * @param  [type] $records [description]
     * @return [type]          [description]
     */
    public function uploadBlankQuestions($records)
    {
        $this->excelRecords = $records;
        $this->questionType = 'blanks';
        $recordsHavingIssues = FALSE;        
        if(!$this->validateQuestions())
            $recordsHavingIssues = TRUE;
        if(!$this->prepareAndPushBlankQuestions())
            $recordsHavingIssues = TRUE;
       
        return $recordsHavingIssues;
    }

    /**
     * This method validates and returns all valid and invalid data
     * The following validations can be made on the data
     * 1) Validate Question types
     * 2) Validate Subject and Topics
     * 3) Validate difficulty level
     * 4) Validate total answers and corrosponding options with that
     * 5) Validity for correct answer number
     * @param  [type] $records [description]
     * @return [type]          [description]
     */
    public function validateQuestions()
    {
        $this->validateQuestionType();
        
        if(!count($this->excelRecords))
            return FALSE;
        $this->validateSubjectsAndTopics();

        if(!count($this->excelRecords))
            return FALSE;
        
        $this->validateDifficultyLevels();

        if(!count($this->excelRecords))
            return FALSE;

       if($this->questionType!='blanks') {
        $this->validateTotalAnswers();
        
        if(!count($this->excelRecords))
            return FALSE;
    }

        return TRUE;


    }

    /**
     * This method returns the valid question type records
     * @return [type] [description]
     */
    public function validateQuestionType()
    {
        $records  = $this->excelRecords;
        foreach($records as $key => $record)
        {
            
            if($record->question_type=='')
                continue;

            if(trim($record->question_type) != $this->questionType) {
               $message = 'this_question_is_not_type_of_'.' '.$this->questionType;
               $this->moveToFailedList($record, $message, $key);
              
                continue;
            }
        }

        return TRUE;        
    }

    public function moveToFailedList($record, $message, $key)
    {
         $temp['record']        = $record;
         $temp['type']          = getPhrase($message);
         $this->failed_list[]   = (object)$temp;
         $this->removeRecordFromList($key);
    }

    /**
     * This method removes the key value pair from source of the questions list
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function removeRecordFromList($key)
    {
        unset($this->excelRecords[$key]);
        return TRUE;
    }

    /**
     * This method validates and returns the valid topics and subjects
     * @return [type] [description]
     */
    public function validateSubjectsAndTopics()
    {
        $this->validateSubjects();
        $this->validateTopics();
    }

    /**
     * This method verifies wether it is the valid subject or not.
     * @return [type] [description]
     */
    public function validateSubjects()
    {
        foreach($this->excelRecords as $key => $record)
        {
            if($record->subject_id=='')
                continue;
            if(!$this->isValidSubject($record->subject_id))
            {
                $message = 'invalid_subject';
                $this->moveToFailedList($record, $message, $key);
            }
        }
        
    }

    /**
     * returns the count of subject if it is available.
     * @param  [type]  $record [description]
     * @return boolean         [description]
     */
    public function isValidSubject($subject_id)
    {
        return Subject::where('id','=',$subject_id)->get()->count();
    }

    /**
     * This method validates the topic along with the subject id
     * @return [type] [description]
     */
    public function validateTopics()
    {
        foreach($this->excelRecords as $key => $record)
        {
             if($record->topic_id=='')
                continue;

            if(!$this->isValidTopic($record->subject_id, $record->topic_id))
            {
                $message = 'topic_not_available_with_subject';
                $this->moveToFailedList($record, $message, $key);
            }
        }
    }

    /**
     * This method validates and returns the count of existing records
     * @param  [type]  $subject_id [description]
     * @param  [type]  $topic_id   [description]
     * @return boolean             [description]
     */
    public function isValidTopic($subject_id, $topic_id)
    {
        return Topic::where('subject_id', '=', $subject_id)
                        ->where('id', '=', $topic_id)->get()->count();
    }

    /**
     * This method validates all difficult levels and filters the list
     * @return [type] [description]
     */
    public function validateDifficultyLevels()
    {
        $difficultyLevels = (new GeneralSettings())->getDifficultyLevels();
        foreach($this->excelRecords as  $key => $record)
        {
             if($record->difficulty_level=='')
                continue;

            if(!array_key_exists($record->difficulty_level, $difficultyLevels))
            {
                 $message = 'invalid_difficulty_level';
                $this->moveToFailedList($record, $message, $key);
            }
        }
    }


    /**
     * This method validates the given number of options and the provided options
     * @return [type] [description]
     */
    public function validateTotalAnswers()
    {
        foreach($this->excelRecords as  $key => $record)
        {
            if($record->total_answers=='')
                continue;
            if(!$this->isAllAnswersAvailable($record))
            {
                 $message = 'insufficient_answers';
                $this->moveToFailedList($record, $message, $key);
            }
        }
    }


    /**
     * This method checks if all the answers are available as per the specifications
     * @param  [type]  $record [description]
     * @return boolean         [description]
     */
    public function isAllAnswersAvailable($record)
    {
        $field = 'answer';
        $keys = $this->getKeys($record);
        for($number = 1; $number<=$record->total_answers; $number++)
        {

            if(!in_array($field.$number,$keys))
            {
                return FALSE;
            }
          
        }

        if($record->correct_answer>=1 && $record->correct_answer<=$record->total_answers)
            return TRUE;
       
        return FALSE;
    }

    /**
     * This method returns the keys from the sent record
     * @param  [type] $record [description]
     * @return [type]         [description]
     */
    public function getKeys($record)
    {
        $keys = array();
        foreach($record as $key=>$value)
        {
            $keys[] = $key;
        }

        return $keys;
    }

    public function getAllColumnsList($records)
    {
        
        $keys = array();

        foreach($records as $item)
        {
            foreach($item as $key=>$value)
            {
                if(!in_array($key,$keys))
                $keys[] = $key;
            }
        }
        return $keys;
    }

    /**
     * This method prepares the questions as per the format required for Radio questions
     * It also pushes the records to tables
     * @return [type] [description]
     */
    public function prepareAndPushRadioQuestions()
    {
        $pushable_records = [];
        foreach($this->excelRecords as $record)    
        {
            if(!$this->isValidSuccessRecord($record))
                continue;
            unset($tempRecord);
            $tempRecord['topic_id']     = $record->topic_id;
            $tempRecord['subject_id']   = $record->subject_id;
            $tempRecord['question_type']= $record->question_type;
            $tempRecord['question']     = $record->question;
            $tempRecord['total_answers']= $record->total_answers;
            $tempRecord['marks']        = $record->marks;
            $tempRecord['total_correct_answers']= 1;
            $tempRecord['correct_answers']= $record->correct_answer;
            $tempRecord['time_to_spend']= $record->time_to_spend;
            $tempRecord['difficulty_level']= $record->difficulty_level;
            $tempRecord['hint']         = ($record->hint) ? $record->hint : '';
            $tempRecord['explanation']  = ($record->explanation) ? $record->explanation : '';
            $tempRecord['answers']      = $this->prepareRadioAnswers($record);
            $pushable_records[]         = $tempRecord;
            $this->success_list[]       = $record;
        }
        return $this->pushToDb($pushable_records);
    }

    public function isValidSuccessRecord($record)
    {
        $valid = FALSE;
        if($record->topic_id=='')
         return $valid;
        if($record->subject_id=='')
            return $valid;

        if($record->question_type=='')
            return $valid;
        if($record->question=='')
            return $valid;
        if($record->total_answers=='')
            return $valid;
        return TRUE;
    }


    /**
     * This method converts the answer to radio type answers which are compatable to this system
     * @param  [type] $record [description]
     * @return [type]         [description]
     */
    public function prepareRadioAnswers($record)
    {
        $answers = [];
        $field = 'answer';
        $keys = $this->getKeys($record);
        for($number = 1; $number<=$record->total_answers; $number++)
        {
            $newkey = $field.$number;
            if(in_array($newkey,$keys))
            {
                unset($temp);
                $temp['option_value']   = $record[$newkey];
                $temp['has_file']       = 0;
                $temp['file_name']      = '';
                $answers[] = $temp;
            }
          
        }

        return json_encode($answers);
    }


    
     public function prepareAndPushCheckboxQuestions()
    {
        $pushable_records = [];
        foreach($this->excelRecords as $record)    
        {
             if(!$this->isValidSuccessRecord($record))
                continue;

            unset($tempRecord);
            $tempRecord['topic_id']     = $record->topic_id;
            $tempRecord['subject_id']   = $record->subject_id;
            $tempRecord['question_type']= $record->question_type;
            $tempRecord['question']     = $record->question;
            $tempRecord['total_answers']= $record->total_answers;
            $tempRecord['marks']        = $record->marks;
            $tempRecord['total_correct_answers']= $record->total_correct_answers;
            $tempRecord['correct_answers']= $this->prepareCorrectAnswers($record);
            $tempRecord['time_to_spend']= $record->time_to_spend;
            $tempRecord['difficulty_level']= $record->difficulty_level;
            $tempRecord['hint']         = ($record->hint) ? $record->hint : '';
            $tempRecord['explanation']  = ($record->explanation) ? $record->explanation : '';
            $tempRecord['answers']      = $this->prepareRadioAnswers($record);
            $pushable_records[]         = $tempRecord;
            $this->success_list[]       = $record;
        }

        
        return $this->pushToDb($pushable_records);
    }


     public function prepareAndPushBlankQuestions()
    {

        $pushable_records = [];
        foreach($this->excelRecords as $record)    
        {
             if(!$this->isValidSuccessRecord($record))
                continue;
            unset($tempRecord);
            $tempRecord['topic_id']     = $record->topic_id;
            $tempRecord['subject_id']   = $record->subject_id;
            $tempRecord['question_type']= $record->question_type;
            $tempRecord['question']     = $record->question;
            $tempRecord['total_answers']= 0;
            $tempRecord['marks']        = $record->marks;
            $tempRecord['total_correct_answers']= $record->total_answers;
            $tempRecord['correct_answers']= $this->prepareCorrectAnswers($record);
            $tempRecord['time_to_spend']= $record->time_to_spend;
            $tempRecord['difficulty_level']= $record->difficulty_level;
            $tempRecord['hint']         = ($record->hint) ? $record->hint : '';
            $tempRecord['explanation']  = ($record->explanation) ? $record->explanation : '';
            $tempRecord['answers']      = '';
            $pushable_records[]         = $tempRecord;
            $this->success_list[]       = $record;
        }

        return $this->pushToDb($pushable_records);
    }

    public function prepareCorrectAnswers($record)
    {
        $answers = [];
        $list = explode(',',$record->correct_answer);
        foreach ($list as $key => $value) {
            $temp['answer'] = $value;
            $answers[] = $temp;
        }
        return json_encode($answers);
    }


    /**
     * This is a generic method to push the question records to database
     * @param  [type] $records [description]
     * @return [type]          [description]
     */
    public function pushToDb($records)
    {
        foreach($records as $record)
        {
            $record = (object)$record;
            $question = new QuestionBank();
            $question->topic_id     = $record->topic_id;
            $question->subject_id   = $record->subject_id;
            $question->question_type= $record->question_type;
            $question->question     = $record->question;
            $question->total_answers= $record->total_answers;
            $question->marks        = $record->marks;
            $question->total_correct_answers = $record->total_correct_answers;
            $question->correct_answers = $record->correct_answers;
            $question->time_to_spend = $record->time_to_spend;
            $question->difficulty_level = $record->difficulty_level;
            $question->hint         = $record->hint;
            $question->explanation  = $record->explanation;
            $question->answers      = $record->answers;
            $question->slug         = $this->makeSlug(getHashCode());
            $question->save();
        }
    }



}
