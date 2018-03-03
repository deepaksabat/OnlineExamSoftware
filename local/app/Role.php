<?php 

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	protected $fillable = ['name', 'display_name', 'description'];

	public static function getRoles()
	{
		return Role::all();		
	}

	 /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user');
    }

    public static function getRoleId($role_name)
    {
    	return Role::where('name', '=', $role_name)->get()->first();
    }
 


}