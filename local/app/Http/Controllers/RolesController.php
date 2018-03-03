<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use Auth;

class RolesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {

    	$data['roles']   			= Role::all();
    	$data['active_class']   	= 'users';
    	$data['sub_active_class']   = 'roles';
    	$data['title']          	= getPhrase('user_roles');
    	return view('users.roles.list-roles', $data);
		
    }

    public function addRole()
    {

        $data['active_class']       = 'users';
        $data['title']              = getPhrase('add_role');
        $data['sub_active_class']   = 'roles';

        return view('users.roles.add-roles', $data);
    }


    public function edit(Role $id)
    {
        
        $data['role']               = $id;
        $data['active_class']       = 'users';
        $data['title']              = getPhrase('edit_role');
        $data['sub_active_class']   = 'roles';

        return view('users.roles.edit-roles', $data);
    }

    public function update(Request $request)
    {
        $role = Role::find($request->id);
        $this->validate($request, [
        'name'          => 'bail|required|max:20',
        'display_name'  => 'required' 
        ]);
        
        $role->name          = $request->name;
        $role->display_name  = $request->display_name;
        $role->description   = $request->description;
        $role->save();
        flash('success','record_updated_successfully', 'success');
        return redirect('roles');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
        'name'          => 'bail|required|unique:roles|max:20',
        'display_name'  => 'required' 
        ]);
        
        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
      
        flash('success','Record_added_successfully', 'success');
    	return redirect('roles');
    }

    public function delete($id)
    {
        // Role::destroy($id);
        // return 1;
    }
}
