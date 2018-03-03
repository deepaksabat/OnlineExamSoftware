<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QuizResult;
use App\Quiz;
use DB;
class ExamTopper extends Model
{
    protected $table = 'examtoppers';

  

    public static function getRecordWithSlug($slug)
    {
        return ExamTopper::where('slug', '=', $slug)->first();
    }

    /**
     * This method validates the user score with the quiz and does the following operations
     * 1) compares the percentage with the minimum percentage to be a topper from exam settings
     * 2) If eligible with the minimum percentage critira 
     *    2.1) then compares the toppers list in the quiz that having less then
     *         the current percentage of this user
     *    2.2) gets the latest percentage score in the list or results associated with quiz id
     *    2.3) removes the old records from toppers list and updates the new list of records
     * 3) Any of the condition fails, it ignores the operations.
     * @param  [type] $quiz_id    [description]
     * @param  [type] $user_id    [description]
     * @param  [type] $percentage [description]
     * @param  string $result_id  [description]
     * @return [type]             [description]
     */
    public function validateWithExamTopper($quiz_id, $user_id, $percentage)
    {

        $examSettings = getExamSettings();
        $eligibleAsTopper = TRUE;
        
        if(!$percentage >= $examSettings->topper_percentage) {
            $eligibleAsTopper = FALSE;
            return $eligibleAsTopper;
        }
        $total_records = $this->isToppersTableEmpty($quiz_id);
        if($total_records)
        {
            $toppers_with_minimum_percentage = ExamTopper::where('quiz_id', '=', $quiz_id)
                                        ->where('percentage', '<=', $percentage)
                                        ->get()->count();
            if(!$toppers_with_minimum_percentage && $total_records == $examSettings->maximum_toppers_per_quiz)
            { 
                // dd('hre');
                return $eligibleAsTopper = FALSE;
            }
        }

        
        // $new_list_of_toppers = QuizResult::where('quiz_id', '=', $quiz_id)
        //                                     ->where('percentage','>=', $examSettings->topper_percentage)
        //                                     ->groupBy('user_id', 'quiz_id')
        //                                     ->orderBy('percentage', 'desc')
        //                                     ->limit(10)->get();

        $new_list_of_toppers = $this->getBestQuizRecords($quiz_id);
        // $new_list_of_toppers = $this->getQuizRecords($quiz_id);
       // dd($new_list_of_toppers);

        
        ExamTopper::where('quiz_id', '=', $quiz_id)->delete();
        $rank = 1;
        foreach($new_list_of_toppers as $newtopper) {
            $topper = new ExamTopper();
            $topper->slug = $newtopper->slug;
            $topper->user_id = $newtopper->user_id;
            $topper->percentage = $newtopper->percentage;
            $topper->quiz_id = $newtopper->quiz_id;
            $topper->quiz_result_id = $newtopper->id;
            $topper->rank = $rank++;
            $topper->save();
        }

        return $eligibleAsTopper;

    }

    /**
     * It returns the count of records available with the quizid in ToppersTable
     * @param  [type]  $quiz_id [description]
     * @return boolean          [description]
     */
    public function isToppersTableEmpty($quiz_id)
    {
        return ExamTopper::where('quiz_id','=',$quiz_id)->get()->count();
    }

        /**
     * Returns the current quiz user record
     * @return [type] [description]
     */
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * This method returns the list of toppers available for the quiz
     * @param  [type] $quizid [description]
     * @return [type]         [description]
     */
    public function getToppersList($quiz_id)
    {
        return ExamTopper::where('quiz_id', '=', $quiz_id)
                        ->orderBy('percentage', 'DESC')
                        ->get();
    }

    /**
     * This method calculates the current Rank in the system and returns the rank number
     * 1) Get the best percentages from results table order by desc group by UserId, QuizId
     * 2) Find the user position in the generated list
     * 3) User position +1 is the current Rank for that user for that quiz
     * @param  [type] $quiz_id    [description]
     * @param  [type] $user_id    [description]
     * @param  [type] $percentage [description]
     * @return [type]             [description]
     */
    public function updateCurrentRank($quiz_id, $user_id, $percentage)
    {
        $records = $this->getBestQuizRecords($quiz_id);
        $rank = $this->findRankOfUser($records, $user_id);
        $total_users_for_this_quiz = count($records);
        // echo $user_id;
        // dd($records);
        
        return array('rank' => $rank, 
                'total_users'=>$total_users_for_this_quiz);
        
    }

    public function findRankOfUser($records, $user_id)
    {
        $rank = 1;
        foreach($records as $record)
        {
            if($record->user_id == $user_id)
                return $rank;
            $rank++;
        }
        return $rank;
    }
    
    /**
     * This method fetches the maximum percentage scored by userid associated to quiz id
     * @param  [type] $quiz_id [description]
     * @return [type]          [description]
     */
    public function getBestQuizRecords($quiz_id)
    {
        // return QuizResult::where('quiz_id','=',$quiz_id)
        //                     ->groupBy('quiz_id','user_id')
                            
        //                     ->get(['user_id', DB::raw('MAX(percentage) as percentage'),'quiz_id','slug','id']);
       return  QuizResult::where('quiz_id', '=', $quiz_id)
                     ->where('percentage','>=',getExamSettings()->topper_percentage)
                     ->orderBy('percentage', 'desc')
                     ->groupBy('quiz_id','user_id')
                     ->get();

    }

    /**
     * This method fetches the maximum percentage scored by userid associated to quiz id
     * @param  [type] $quiz_id [description]
     * @return [type]          [description]
     */
    public function getQuizRecords($quiz_id)
    {
        return QuizResult::where('quiz_id','=',$quiz_id)
                            ->groupBy('quiz_id','user_id')
                            ->get(['user_id', DB::raw('MAX(percentage) as percentage'),'quiz_id']);
    }


    /**
     * This method returns the list of toppers,
     * Topper record (the topper may be selected by user or the toppest performer of specific quiz)
     * @param  [type] $userSlug   [description]
     * @param  string $topperSlug [description]
     * @return [type]             [description]
     */
    public function getResultRecords($userSlug, $topperSlug = '')
    {
        $user_record = QuizResult::where('quizresults.slug','=',$userSlug)->first();
        
        $resultObject = new QuizResult();
        $toppers = array();
        $toppers = $this->getToppersList($user_record->quiz_id);
        // dd($toppers);

        $quiz_record = Quiz::where('id',$user_record->quiz_id)->first();
        $total_users  = $this->getUsersInQuiz($user_record->quiz_id);
        $topper_record = array();

        // $bestRecords = $this->getBestQuizRecords($user_record->quiz_id);
        // dd($bestRecords);

        if($topperSlug == '')
        {
            if(count($toppers))
            $topper_record = $toppers[0];
        }

        else {
            $topper_record = QuizResult::where('slug', '=', $topperSlug)->first();
        }

        return array(
                      'toppers' => $toppers,
                      'topper_record' => $topper_record,
                      'user_record' => $user_record,
                      'total_users' => $total_users,
                      'quiz_record' => $quiz_record
                      );
    }

    /**
     * Returns the no. of users present in the quiz
     * @param  [type] $quiz_id [description]
     * @return [type]          [description]
     */
    public function getUsersInQuiz($quiz_id)
    {
        return QuizResult::where('quiz_id',$quiz_id)
                            ->groupBy('quiz_id','user_id')
                            ->get()->count();
    }


    /**
     * This method calculates and returns the sum of time spent and time_to_spend
     * records from the sent json data
     * @param  [type] $json_data [description]
     * @return [type]            [description]
     */
    public function getTimeAnalysis($json_data)
    {
        $records = json_decode($json_data);
         $time_to_spend = 0;
        $time_spent = 0;

        if(!count($records))
        {
            return array('time_to_spend' => $time_to_spend, 'time_spent' => $time_spent);
        }

       
        foreach($records as $record)
        {
            $time_to_spend  += $record->time_to_spend;
            $time_spent     += $record->time_spent;
        }

        return array('time_to_spend' => $time_to_spend, 'time_spent' => $time_spent);
    }

    /**
     * This method finds and returns the best rank in specific quiz assoiated to the user
     * @param  [type] $quiz_id [description]
     * @return [type]          [description]
     */
    
    public function rankOfUserInQuiz($quiz_id, $user_id)
    {
        
        $result= QuizResult::where('quiz_id','=',$quiz_id)
                            ->groupBy('quiz_id','user_id')
                            ->orderBy('percentage','desc')
                            ->get(['user_id', DB::raw('MAX(percentage) as percentage'),'quiz_id']);
        // dd($result);
        return $this->findRankOfUser($result, $user_id);
        
                   

                            
    }
}
