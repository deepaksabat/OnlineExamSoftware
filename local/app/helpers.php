<?php

/**
 * Flash Helper
 * @param  string|null  $title
 * @param  string|null  $text
 * @return void
 */


function flash($title = null, $text = null, $type='info')
{
    $flash = app('App\Http\Flash');

    if (func_num_args() == 0) {
        return $flash;
    }
    return $flash->$type($title, $text);
}

/**
 * Language Helper
 * @param  string|null  $phrase
 * @return string
 */
function getPhrase($key = null)
{
  
    $phrase = app('App\Language');

    if (func_num_args() == 0) {
        return '';
    }

    return  $phrase::getPhrase($key); 
}

/**
 * This method fetches the specified key in the type of setting
 * @param  [type] $key          [description]
 * @param  [type] $setting_type [description]
 * @return [type]               [description]
 */
function getSetting($key, $setting_type)
{
    return App\Settings::getSetting($key, $setting_type);
}

/**
 * Language Helper
 * @param  string|null  $phrase
 * @return string
 */
function isActive($active_class = '', $value = '')
{
    $value = isset($active_class) ? ($active_class == $value) ? 'active' : '' : '';
    if($value)
        return "class = ".$value;
    return $value; 
}

/**
 * This method returns the path of the user image based on the type
 * It verifies wether the image is exists or not, 
 * if not available it returns the default image based on type
 * @param  string $image [Image name present in DB]
 * @param  string $type  [Type of the image, the type may be thumb or profile, 
 *                       by default it is thumb]
 * @return [string]      [returns the full qualified path of the image]
 */
function getProfilePath($image = '', $type = 'thumb')
{
    $obj = app('App\ImageSettings');
    $path = '';
    
    if($image=='') {
        if($type=='profile')
            return PREFIX.$obj->getDefaultProfilePicPath();
        return PREFIX.$obj->getDefaultprofilePicsThumbnailpath();
    }
  

    if($type == 'profile')
        $path = $obj->getProfilePicsPath();
    else
        $path = $obj->getProfilePicsThumbnailpath();
    $imageFile = $path.$image;

    if (File::exists($imageFile)) {
        return PREFIX.$imageFile;
    }

    if($type=='profile')
        return PREFIX.$obj->getDefaultProfilePicPath();
    return PREFIX.$obj->getDefaultprofilePicsThumbnailpath();

}

/**
 * This method returns the standard date format set by admin
 * @return [string] [description]
 */
function getDateFormat()
{
    $obj = app('App\GeneralSettings');
    return $obj->getDateFormat(); 
}


function getBloodGroups()
{
    return array(
            'A +ve'    => 'A +ve',
            'A -ve'    => 'A -ve',
            'B +ve'    => 'B +ve',
            'B -ve'    => 'B -ve',
            'O +ve'    => 'O +ve',
            'O -ve'    => 'O -ve',
            'AB +ve'   => 'AB +ve',
            'AB -ve'   => 'AB -ve',
        );
}

function getAge($date)
{
    

    // return Carbon::createFromDate(1984, 7, 17)->diff(Carbon::now())->format('%y years, %m months and %d days');
}

function getLibrarySettings()
{
    return json_decode((new App\LibrarySettings())->getSettings());
}

function getExamSettings()
{
    return json_decode((new App\ExamSettings())->getSettings());
}

/**
 * This method is used to generate the formatted number based 
 * on requirement with the follwoing formatting options
 * @param  [type]  $sno    [description]
 * @param  integer $length [description]
 * @param  string  $token  [description]
 * @param  string  $type   [description]
 * @return [type]          [description]
 */
function makeNumber($sno, $length=2, $token = '0',$type='left')
{
    if($type=='right')
        return str_pad($sno, $length, $token, STR_PAD_RIGHT);
    
    return str_pad($sno, $length, $token, STR_PAD_LEFT);
    
}
 
/**
 * This method returns the settings for the selected key
 * @param  string $type [description]
 * @return [type]       [description]
 */
function getSettings($type='')
{
    if($type=='lms')
        return json_decode((new App\LmsSettings())->getSettings());
    
    if($type=='subscription')
        return json_decode((new App\SubscriptionSettings())->getSettings());
    
    if($type=='general')
        return json_decode((new App\GeneralSettings())->getSettings());

    if($type=='email'){

        $dta = json_decode((new App\EmailSettings())->getSettings());
        return $dta;
      }
   
   if($type=='attendance')
        return json_decode((new App\AttendanceSettings())->getSettings());

}

/**
 * This method returns the role of the currently logged in user
 * @return [type] [description]
 */
 function getRole($user_id = 0)
 {
     if($user_id)
        return getUserRecord($user_id)->roles()->first()->name;
     return Auth::user()->roles()->first()->name;
 }

/**
 * This is a common method to send emails based on the requirement
 * The template is the key for template which is available in db
 * The data part contains the key=>value pairs 
 * That would be replaced in the extracted content from db
 * @param  [type] $template [description]
 * @param  [type] $data     [description]
 * @return [type]           [description]
 */
 function sendEmail($template, $data)
 {
    return (new App\EmailTemplate())->sendEmail($template, $data);
 }

/**
 * This method returns the formatted by appending the 0's
 * @param  [type] $number [description]
 * @return [type]         [description]
 */
 function formatPercentage($number)
 {
     return sprintf('%.2f',$number).' %';
 }


/**
 * This method returns the user based on the sent userId, 
 * If no userId is passed returns the current logged in user
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
 function getUserRecord($user_id = 0)
 {
    if($user_id)
     return (new App\User())->where('id','=',$user_id)->first();
    return Auth::user();
 }

/**
 * Returns the user record with the matching slug.
 * If slug is empty, it will return the currently logged in user
 * @param  string $slug [description]
 * @return [type]       [description]
 */
function getUserWithSlug($slug='')
{
    if($slug)
     return App\User::where('slug', $slug)->get()->first();
    return Auth::user();
}

/**
 * This method identifies if the url contains the specific string
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
 function urlHasString($str)
 {
    $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
     if (strpos($url, $str)) 
        return TRUE;
    return FALSE;
                
 }

 function checkRole($roles)
 {
     if(Entrust::hasRole($roles))
        return TRUE;
    return FALSE;
 }

 function getUserGrade($grade = 5)
 {
     switch ($grade) {
         case 1:
             return ['owner'];
             break; 
        case 2:
             return ['owner', 'admin'];
             break;
        case 3:
             return ['owner', 'admin', 'staff'];
             break;
        case 4:
             return ['owner', 'admin', 'parent'];
             break;
        case 5:
             return ['student'];
             break;
        case 6:
             return ['admin'];
             break; 
        case 7:
             return ['parent'];
             break; 
         
     }
 }
 /**
  * Returns the appropriate layout based on the user logged in
  * @return [type] [description]
  */
 function getLayout()
 {
    $layout = 'layouts.student.studentlayout';
    if(checkRole(getUserGrade(2)))
        $layout             = 'layouts.admin.adminlayout';
    if(checkRole(['parent']))
        $layout             = 'layouts.parent.parentlayout';

    return $layout;
 }

 function validateUser($slug)
 {
    if($slug == Auth::user()->slug)
        return TRUE;
    return FALSE;
 }

 /**
  * Common method to send user restriction message for invalid attempt 
  * @return [type] [description]
  */
 function prepareBlockUserMessage()
 {
    flash('Ooops..!', 'you_have_no_permission_to_access', 'error');
     return '';
 }

 /**
  * Common method to send user restriction message for invalid attempt 
  * @return [type] [description]
  */
 function pageNotFound()
 {
    flash('Ooops..!', 'page_not_found', 'error');
     return '';
 }
 

 function isEligible($slug)
 {
     if(!checkRole(getUserGrade(2)))
     {
        if(!validateUser($slug)) 
        {
            if(!checkRole(['parent']) || !isActualParent($slug))
            {
               prepareBlockUserMessage();
               return FALSE;
            }
        }
     }
     return TRUE;
 }

 /**
  * This method checks wether the student belongs to the currently loggedin parent or not
  * And returns the boolean value
  * @param  [type]  $slug [description]
  * @return boolean       [description]
  */
 function isActualParent($slug)
 {
     return (new App\User())
              ->isChildBelongsToThisParent(
                                    getUserWithSlug($slug)->id, 
                                    Auth::user()->id
                                    );

 }

/**
 * This method returns the role name or role ID based on the type of parameter passed
 * It returns ID if role name is supplied
 * It returns Name if ID is passed
 * @param  [type] $type [description]
 * @return [type]       [description]
 */
 function getRoleData($type)
 {
    
     if(is_numeric($type))
     {
        /**
         * Return the Role Name as the type is numeric
         */
        return App\Role::where('id','=',$type)->first()->name;
        
     }

     //Return Role Id as the type is role name
     return App\Role::where('name','=',$type)->first()->id;

 }

 /**
  * Checks the subscription details and returns the boolean value
  * @param  string  $type [this is the of package]
  * @return boolean       [description]
  */
 function isSubscribed($type = 'main',$user_slug='')
 {
    $user = getUserWithSlug();
    if($user_slug)
        $user = getUserWithSlug($user_slug);
    
    if($user->subscribed($type))
      return TRUE;
    return FALSE;
 }

/**
 * This method will send the random color to use in graph
 * The random color generation is based on the number parameter 
 * As the border and bgcolor need to be same, 
 * We are maintainig number parameter to send the same value for bgcolor and background color
 * @param  string  $type   [description]
 * @param  integer $number [description]
 * @return [type]          [description]
 */
 function getColor($type = 'background',$number = 777) {

    $hash = md5('color'.$number); // modify 'color' to get a different palette
    $color = array(
        hexdec(substr($hash, 0, 2)), // r
        hexdec(substr($hash, 2, 2)), // g
        hexdec(substr($hash, 4, 2))); //b
    if($type=='border')
    return 'rgba('.$color[0].','.$color[1].','.$color[2].',1)';
    return 'rgba('.$color[0].','.$color[1].','.$color[2].',0.2)';
}


function pushNotification($channels = ['owner','admin'], $event = 'newUser',  $options)
{

     $pusher = \Illuminate\Support\Facades\App::make('pusher');

         $pusher->trigger( $channels,
                      $event, 
                      $options
                     );

         

}

/**
 * This method is used to return the default validation messages
 * @param  string $key [description]
 * @return [type]      [description]
 */
function getValidationMessage($key='required')
{
    $message = '<p ng-message="required">'.getPhrase('this_field_is_required').'</p>';    
    
    if($key === 'required')
        return $message;

        switch($key)
        {
          case 'minlength' : $message = '<p ng-message="minlength">'
                                        .getPhrase('the_text_is_too_short')
                                        .'</p>';
                                        break;
          case 'maxlength' : $message = '<p ng-message="maxlength">'
                                        .getPhrase('the_text_is_too_long')
                                        .'</p>';
                                        break;
          case 'pattern' : $message   = '<p ng-message="pattern">'
                                        .getPhrase('invalid_input')
                                        .'</p>';
                                        break;
            case 'image' : $message   = '<p ng-message="validImage">'
                                        .getPhrase('please_upload_valid_image_type')
                                        .'</p>';
                                        break;
          case 'email' : $message   = '<p ng-message="email">'
                                        .getPhrase('please_enter_valid_email')
                                        .'</p>';
                                        break;
                                       
          case 'number' : $message   = '<p ng-message="number">'
                                        .getPhrase('please_enter_valid_number')
                                        .'</p>';
                                        break;

          case 'confirmPassword' : $message   = '<p ng-message="compareTo">'
                                        .getPhrase('password_and_confirm_password_does_not_match')
                                        .'</p>';
                                        break;
           case 'password' : $message   = '<p ng-message="minlength">'
                                        .getPhrase('the_password_is_too_short')
                                        .'</p>';
                                        break;
           case 'phone' : $message   = '<p ng-message="minlength">'
                                        .getPhrase('please_enter_valid_phone_number')
                                        .'</p>';
                                        break;
        }
    return $message;
}

/**
 * Returns the predefined Regular Expressions for validation purpose
 * @param  string $key [description]
 * @return [type]      [description]
 */
function getRegexPattern($key='name')
{
    $phone_regx = getSetting('phone_number_expression', 'site_settings');
    $pattern = array(
                    'name' => '/^[a-zA-Z0-9_\'.- ]*$/',
                    'email' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
                    'phone'=>$phone_regx
                    );
    return $pattern[$key];
}

function getPhoneNumberLength()
{
  return getSetting('site_favicon', 'site_settings');
}


function getArrayFromJson($jsonData)
{
    $result = array();
    if($jsonData)
    {
        foreach(json_decode($jsonData) as $key=>$value)
            $result[$key] = $value;
    }
    return $result;
}


function prepareArrayFromString($string='', $delimeter = '|')
{
  
    return explode($delimeter, $string);
}

/**
 * Returns the random hash unique code
 * @return [type] [description]
 */
function getHashCode()
{
  return bin2hex(openssl_random_pseudo_bytes(20));
}

/**
 * Sends the default Currency set for the project
 * @return [type] [description]
 */
function getCurrencyCode()
{
  return getSetting('currency_code','site_settings') ;
}

/**
 * Returns the max records per page
 * @return [type] [description]
 */
function getRecordsPerPage()
{
  return RECORDS_PER_PAGE;
}

/**
 * Checks wether the user is eligible to use the current item
 * @param  [type]  $item_id   [description]
 * @param  [type]  $item_type [description]
 * @return boolean            [description]
 */
function isItemPurchased($item_id, $item_type, $user_id = '')
{
  return App\Payment::isItemPurchased($item_id, $item_type, $user_id);
}

function humanizeDate($target_date)
{
   $created = new \Carbon\Carbon($target_date);
   $now = \Carbon\Carbon::now();
   $difference = ($created->diff($now)->days < 1) ? getPhrase('today') 
                                : $created->diffForHumans($now);
    return $difference;
}


function getTimeFromSeconds($seconds)
{
    return gmdate("H:i:s",$seconds);
}
