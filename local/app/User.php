<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Cashier\Billable;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    use EntrustUserTrait;
    use Billable;
    use Messagable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    
    public function staff()
    {
        return $this->hasOne('App\Staff');
    }
 
     /**
     * The roles that belong to the user.
     */
    public function roles()
    {
         return $this->belongsToMany('App\Role', 'role_user');
         
    }


     
    /**
     * Returns the student record from students table based on the relationship
     * @return [type]        [Student Record]
     */
    public function student()
    {
        return $this->hasOne('App\Student');
    }

    



    public static function getRecordWithSlug($slug)
    {
        return User::where('slug', '=', $slug)->first();
    }

    public function isChildBelongsToThisParent($child_id, $parent_id)
    {
        return User::where('id', '=', $child_id)
              ->where('parent_id','=',$parent_id)
              ->get()
              ->count();
    }

    public function getLatestUsers($limit = 5)
    {
        return User::where('role_id','=',getRoleData('student'))
                     ->orderBy('id','desc')
                     ->limit($limit)
                     ->get();
    }


     /**
      * This method accepts the user object from social login methods 
      * Registers the user with the db
      * Sends Email with credentials list 
      * @param  User   $user [description]
      * @return [type]       [description]
      */
     public function registerWithSocialLogin($receivedData = '')
     {
        $user        = new User();
        $password         = str_random(8);
        $user->password   = bcrypt($password);
        $slug             = $user->makeSlug($receivedData->name);
        $user->username   =  $slug;
        $user->slug       = $slug;

        $role_id        = getRoleData('student');
        
        $user->name  = $receivedData->name;
        $user->email = $receivedData->email;
        $user->role_id = $role_id;
        $user->login_enabled  = 1;
         if(!env('DEMO_MODE')) {
        $user->save();
        $user->roles()->attach($user->role_id);
        sendEmail('registration', array('user_name'=>$user->name, 'username'=>$user->slug, 'to_email' => $user->email, 'password'=>$password));
        }
       return $user;
     }
}
