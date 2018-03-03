<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class GeneralSettings extends Model
{
    protected $pageLength 		= 10;

    protected $staffIDPrefix    = 'ACA';
    
    protected $studentIDPrefix  = 'ACASTU';
    
    protected $studentAdmissionNoLength = 5;

    protected $staffSettings	= array();

    protected $staffExtraFields = array();
    
    protected $systemDateFormat	= "yyyy/mm/dd";

    protected $countries        = array();
    

    protected $questionTypes    = array(
                                        ''              => 'Select',
                                        'radio'         => 'Single Answer',
                                        'checkbox'      => 'Multi Answer',
                                        'blanks'        => 'Fill in blanks',
                                        'match'         => 'Match the following',
                                        'para'          => 'Paragraph',
                                        'video'         => 'Video',
                                        'audio'         => 'Audio',
                                        );
    protected $difficultyLevels = array(
                                        'easy'          => 'Easy',
                                        'medium'        => 'Medium',
                                        'hard'          => 'Hard',
                                        );
    protected $examMaxOptions = 10;
    protected $settings      = array('gradeSystem' => 'percentage_title');

    public function getSettings()
    {
        return json_encode($this->settings);
    }

    /**
     * page length for displaying records in table
     * @param integer $length [description]
     */
    public function setPageLength($length = 10)
    {
    	$this->pageLength = $length;
    }

    /**
     * return page length for displaying records in table
     */
    public function getPageLength()
    {
    	return $this->pageLength;
    }

    /**
     * This method is used to return staff ID prefix to be appended
     * @return [string] Staff ID
     */
    public function getStaffIDPrefix()
    {
    	return $this->staffIDPrefix;
    }

     /**
     * This method is used to return student ID prefix to be appended
     * @return [string] Student ID
     */
    public function getStudentIDPrefix()
    {
        return $this->studentIDPrefix;
    }

     /**
     * This method is used to return student ID prefix to be appended
     * @return [integer] Length
     */
    public function getAdmissionNoLength()
    {
        return $this->studentAdmissionNoLength;
    }

    /**
     * To set the Universal date format for the system
     * @param string $format [valid date format]
     */
    public function setDateFormat($format='yyyy/mm/dd')
    {
        $this->systemDateFormat = $format;
    }

    /**
     * Returns the default/current Date format
     * @return [type] [description]
     */
    public function getDateFormat()
    {
        return $this->systemDateFormat;
    }

    public function getCountries($value='')
    {
        $countries = DB::table('countries')->pluck('country_name', 'country_code');
        return $countries;
    }
    /**
     * Returns the types of questions available in system
     * @return [array] [description]
     */
    public function getQuestionTypes()
    {
        return $this->questionTypes;
    }

    /**
     * Returns the difficulty levels available in system
     * @return [array] [description]
     */
    public function getDifficultyLevels()
    {
        return $this->difficultyLevels;
    }

    /**
     * Returns the Maximum no. of options available in exam system
     * @return [array] [description]
     */
    public function getExamMaxOptions()
    {
        $options = [];
        for($i=0; $i < $this->examMaxOptions; $i++)
            $options[] = $i;
        return $options;
    }
}
