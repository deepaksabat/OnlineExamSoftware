<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;
use App\Http\Requests;
use PDO;
use Exception;
use Input;
use App\User;
class InstallatationController extends Controller
{

	var $res = TRUE;
	public $conn = '';

	/**
	 * This method is called for the first time is not database exists
	 * @return [type] [description]
	 */
     public function index()
    {
        $data['title']              = 'Install';
    	return view('install.index', $data);
    }

    /**
     * This method handles request to setup installatation process
     * Follow the below steps
     * 1) Take the db details and install the database with the specified option 
     * i.e, with or without data
     * 2) update .env file
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function installProject(Request $request)
    {
        // dd($request);
         ini_set('max_execution_time', 300);
         // dd($request);
    	$columns = array(
	        'host_name'  => 'bail|required',
	        'database_name' => 'bail|required',
            'user_name' => 'bail|required',
            
        );

        
     	$this->validate($request,$columns);
          // $dta = Input::all();
           //Attempt to create database
        if($this->createDatabase($request)==0)
            return redirect(URL_INSTALL_SYSTEM) ;
        
        //Attempt to load data to tables
        if($this->createTables($request)==0)
        {
            return redirect(URL_INSTALL_SYSTEM) ;
        }
         
        //Attempt to set env variables
         if($this->updateEnvironmentFile($this->prepareEnvData($request))==0)
         {
            return redirect(URL_INSTALL_SYSTEM) ;
         }
        
    

        $flash = app('App\Http\Flash');
            $flash->create('Success...!', 'Project Installed Successfully', 'success', 'flash_overlay',FALSE);

         // return redirect(PREFIX);
          // unset($dta['_token']);
         
          $data['title']              = 'Register user';
            if($request->has('sample_data'))
        {
            if($request->sample_data!='no_data')
            {
                return redirect(PREFIX);
            }
        }
          
        return view('install.first-user-after-install', $data);
     	
    }

    public function reg()
    {
          $data['title']              = 'Register user';
        
        return view('install.first-user-after-install', $data);
    }

    public function registerUser(Request $request)
    {

        $columns = array(
            
            'owner_name' => 'bail|required',
            'owner_user_name' => 'bail|required',
            'owner_email' => 'bail|required',
            'owner_password' => 'bail|required',
        );
    $this->validate($request,$columns);

        // Everything is fine, create user to the system and redirect to login page
        $user           = new User();
        $name           = $request->owner_name;
        $user->name     = $name;
        $user->name     = $request->owner_name;
        $user->email    = $request->owner_email;
        $user->username = $request->owner_user_name;
        $user->password = bcrypt($request->owner_password);
        $user->role_id  = 1;
        $user->login_enabled  = 1;
        $user->slug = $user->makeSlug($name);

        $user->save();
        $user->roles()->attach($user->role_id);
       
        return redirect(PREFIX);
    }

    // Function to the database and tables and fill them with the default data
	function createDatabase(Request $request)
	{
        
    	$servername = $request->host_name;
		$username = $request->user_name;
		$password = $request->password;
		$database = $request->database_name;
        
		try 
		{
		    $this->conn = new PDO("mysql:host=$servername", $username, $password);
		    // set the PDO error mode to exception
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $this->conn->exec("CREATE DATABASE IF NOT EXISTS `$database` ;") ;
		    $this->conn = new PDO("mysql:host=$servername; dbname=$database", $username, $password);
		}
		catch(Exception $e)
		{
		    $message = "Connection failed: " . $e->getMessage();
			$flash = app('App\Http\Flash');
		    $flash->create('Ooops...!', $message, 'error', 'flash_overlay',FALSE);
			return 0;	

		}
		return 1;
 	}

     function get_content($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }


	// Function to create the tables and fill them with the default data
	function createTables(Request $request)
	{
        // dd($request)
		try{
			$query = '';
		// Open the default SQL file
		if($request->has('sample_data'))
		{
			$query = $this->get_content(DOWNLOAD_SAMPLE_DATA_DATABASE);
		}
		else
		{
	
			$query = $this->get_content(DOWNLOAD_EMPTY_DATA_DATABASE);
		}
			$this->conn->exec($query);
	 	}
	 	catch(Exception $ex)
	 	{
	 		$message = "Connection failed: " . $ex->getMessage();
			$flash = app('App\Http\Flash');
		    $flash->create('Ooops...!', $message, 'error', 'flash_overlay',FALSE);
			return 0;	
	 	}
		return 1;
	}

	/**
	 * This method will prepare database details data to update in env file
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function prepareEnvData(Request $request)
	{
		$data['DB_HOST'] 		= $request->host_name;
		$data['DB_PORT'] 		= $request->port_number;
		$data['DB_DATABASE'] 	= $request->database_name;
		$data['DB_USERNAME']	= $request->user_name;
		$data['DB_PASSWORD'] 	= $request->password;
		return $data;
	}


	/**
     * This method updates the Environment File which contains all master settings
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function updateEnvironmentFile($data = array())
    {

    	 
			$flash = app('App\Http\Flash');

      if(count($data)>0) {
       $env = file_get_contents(base_path() . '/.env');
       $env = preg_split('/\s+/', $env);
       
        foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }
             $env = implode("\n", $env);
              file_put_contents(base_path() . '/.env', $env);

                 $flash->create('Success...!', 'Your installatation was success', 'success', 'flash_overlay',FALSE);

      return 1;
    }
    else
    {
    	   $flash->create('Ooops...!', 'Please check your directory permissions', 'error', 'flash_overlay',FALSE);
      return 0;
    }

  }


}
