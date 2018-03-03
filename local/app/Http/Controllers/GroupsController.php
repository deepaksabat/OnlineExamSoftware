<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Group;
class GroupsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
	}
    /**
     * To list the User Groups
     * @return List of available user groups
     */
    public function index()
    {
    	$groups              	= Group::all();
      	$data['groups']      	= $groups;
      	$data['active_class']   = 'users';
      	$data['title']          = getPhrase('user_groups');
    	return view('admin.groups.groups-list', $data);
    }
}
