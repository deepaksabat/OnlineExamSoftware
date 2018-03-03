<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use App\Language;
use App\Common;
class LanguageController extends Controller
{
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }
  
    /**
     * Returns all the available languages 
     * @return [List]
     */
    public function index()
    {
      $languages              = Language::all();
      $data['languages']      = $languages;
      $data['active_class']   = 'languages';
      $data['title']          = getPhrase('languages');
    	return view('languages.list', $data);
    }


    public function editPhrases(Language $language)
    {
       
        $data['language']     = $language;
    	$data['active_class'] ='languages';
        $data['title']        = getPhrase('edit_phrases');

    	 return view('languages.phrases', $data);
  //   	if (Auth::check()) {
  //   		return view('languages.add-language');
		// }
		// else {
		// 	return "Please login to continue";
		// }
    }

    public function updatePhrases(Request $request)
    {
    	 $input_data = $request->all();
    	 $language_phrases = array();
    	 foreach ($input_data as $key => $value) {
    	 	if($key=='_token' || $key=='language_id')
    	 		continue;
    	 	$language_phrases[$key] = $value;
    	 }
       
    	 DB::table('languages')->where('id','=',$request->language_id)->update(['phrases' => json_encode($language_phrases)]);
       Language::resetLanguage();
       flash('success','record_updated_successfully','success');
    	 return back();
    }


    public function store_language(Request $request)
    {
    	$this->validate($request, [
        'language' => 'bail|required|unique:languages|max:20',
        'is_rtl' => 'required',
    	]);

    	$language_id =  env('LANGUAGE_ID');
    	$language_strings = DB::table('languages')->where('id', '=', $language_id)->get();
    	
    	$language = new Language();
    	$language->language = trim($request->language);
    	$language->is_rtl = $request->is_rtl;
    	$language->phrases = $language_strings[0]->phrases;
    	$language->save();
      Language::prepareFlashMessage('record_updated_successfully','success');
    	return back();
    }

    public function store_phrase(Request $request)
    {
    	 $this->validate($request, [
        'phrase' => 'bail|required|max:60',
    	]);
        (new Language())->addPhrase($request->phrase);
         Language::prepareFlashMessage('record_added_successfully','success');
    	return back();
    }

    public function reset_language()
    {
        $language = Language::find(env('LANGUAGE_ID'));
        session()->put('language', $language); 
        session()->put('language_phrases', json_decode($language->phrases)); 
        
    }



    public function listPhrases()
    {

        $language_id = 1;

        $phrases = Language::getPhrasesListByLanguageId($language_id);


        $data['phrases']      = $phrases;
        $data['active_class'] = 'languages';
        $data['title']        = Language::getPhrase('phrases_list');

        return view('languages.phrases-list', $data);
    }


    public function deletePhrase(Request $request)
    {

         $phrase_to_be_deleted = $request->phrase;
         $filtered_phrase_arr  = array();
         $languages_arr      = array();
         $filtered_phrase_json = "";
         $affected         = 0;

         $phrases = Common::fetchRecords('languages', '', array('id', 'phrases'));

         foreach ($phrases as $key => $value) {
          $phrases_arr = (array)json_decode($value->phrases);
          foreach ($phrases_arr as $phrase) {
            unset($phrases_arr[$phrase_to_be_deleted]);
          }
          array_push($filtered_phrase_arr, $phrases_arr);
          array_push($languages_arr, $value->id);
         }


         foreach ($filtered_phrase_arr as $key => $value) {

          $filtered_phrase_json = json_encode($value);

          $affected = Common::updateRecords('languages', array('phrases' => $filtered_phrase_json), array('id' => $languages_arr[$key]));

         }

         if($affected > 0) {

          $msg = "record_deleted_successfully.";
          $msg_type = 'success';

         } else {

            $msg = "record_not_deleted.";
            $msg_type = 'danger';
         }

         Language::prepareFlashMessage($msg, $msg_type);
          return redirect('list-phrases');

    }



}
