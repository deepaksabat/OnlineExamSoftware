<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Exception;
class Language extends Model
{

   
    
    /**
     * This method is used to add new phrases to the system
     * @param [type]  $phrase           [phrase key]
     * @param integer $default_language [default language]
     */
   public function addPhrase($phrase, $default_language = 0)
   {
   		if($default_language==0)
   			$default_language_id = Language::getDefaultLanguage();

   		$dta = '';
     
      $default_language = Language::where('id', '=', $default_language_id)->first();
      
      $dta =(array) json_decode($default_language->phrases);
      $dta[strtolower($phrase)] = Language::cleanPhrase($phrase);
      
      if( urlHasString('logout') || urlHasString('login'))
        return;
      
      if($default_language->code != 'en' )
        $dta[strtolower($phrase)] = $this->getTranslatedPhrase(Language::cleanPhrase($phrase), $default_language->code);

      DB::table('languages')->where('id', '=', $default_language->id)->update(['phrases' => json_encode($dta)]);
 
      Language::resetLanguage();
   }

   public function getTranslatedPhrase($phrase, $target_code)
   {
      try
      {
        return translate('en', $target_code, $phrase);
      }
        catch(Exception $ex){
        return $phrase;
      }
   }

   /**
    * [This method is used to get the language phrase based on default language with specific key, If key is not available, it will add new key to db and inserts an english key and returns an english string as language key ]
    * @param  [type] $key [Language Key]
    * @return [type]      [description]
    */
    public static function getPhrase($key)
    {

      $key = strtolower($key);

  	 return Language::isKeyExists($key) ;
	   
    }

    /**
     * [this methos returns the default language selceted by amdin for that site]
     * @return [type] [description]
     */
    public static function getDefaultLanguage()
    {
      return Language::getDefaultLanguageRecord()->id;
    }

    /**
     * This method returns the default language Record
     * The sent record can be used in anyother methods
     * @return [type] [description]
     */
    public static function getDefaultLanguageRecord()
    {
     return Language::where('is_default', '=', 1)->first();
     
    }

    /**
     * This methos returns the current language is RTL or not 
     * based on the default language.
     * @return boolean [description]
     */
    public static function isDefaultLanuageRtl()
    {
      return Language::getDefaultLanguageRecord()->is_rtl;
    }    

    /**
     * [this method verifies if key exists in the db or not, if not exists adds to db]
     * @param  [type]  $key [description]
     * @return boolean      [description]
     */
  protected static function isKeyExists($key)
	{

		if(!session()->has('language_phrases'))
    	{  
         Language::resetLanguage();
    	}
      
      $language_phrases = (array) session('language_phrases');
    
    

		if(array_has($language_phrases, $key)) {
     //Language key exists, so returns respective language string 		 
			return $language_phrases[$key];
		}
		else {
      //Language key dosn't  exists, so returns requested string string by adding the language to db
      
			(new Language())->addPhrase($key);
      
			return Language::cleanPhrase($key);

		}
	}

  /**
   * [this method cleans the key by before ading the key to db]
   * @param  [type] $phrase [description]
   * @return [type]         [description]
   */
	 public static function cleanPhrase($phrase)
    {
    	return ucwords(str_replace('_', ' ', $phrase));
    }
	 
   /**
    * [This method is used to reset the language session after the admin changes his language option ]
    * @return [type] [description]
    */
  	public static function resetLanguage()
    {
      
        session()->forget('language_phrases');
        $language = Language::where('id', '=', Language::getDefaultLanguage())->first();
        session()->put('language_phrases', json_decode($language->phrases)); 
        
    }


  public static function getRecordsPerPage()  
  {
    // $PAGE_SIZE = 2;
    // return $PAGE_SIZE;
  }

  public static function prepareFlashMessage($message, $message_type='default')
  {
     $msg = '<div class="alert alert-'.$message_type.'">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     '.Language::getPhrase($message).'
   </div>';
    session()->flash('message',$msg);  
    return TRUE;
  }


  public static function getPhrasesListByLanguageId($language_id = '')
  {

    if($language_id == "" || !($language_id > 0))
      $language_id = Language::getDefaultLanguage();

    $phrases = DB::table('languages')->where('id', '=', $language_id)->select('phrases')->first()->phrases;

    return (array)json_decode($phrases);

  }


 

}
