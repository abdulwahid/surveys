<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function showList() {

        $roles = Role::all();
        return view('admin.role.show-list', compact('roles'));
    }

    public function create() {
        return view('admin.role.create');
    }

    public function update($id) {
        $role = Role::findOrFail($id);
        return view('admin.role.update', compact('role'));
    }

    public function postUpdate(Request $request, $id=null) {

        $inputs = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($id) {
            $role = Role::findOrFail($id);
            $actionType = 'updated';
        } else {
            $role = New Role;
            $actionType = 'created';
        }

        $role->name = $inputs['name'];
        $role->description = $inputs['description'];
        $role->save();

        return redirect()->route('admin-roles-list')->with(['message' => 'Role ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin-roles-list')->with(['message' => 'Role Deleted Successfully']);
    }
}
