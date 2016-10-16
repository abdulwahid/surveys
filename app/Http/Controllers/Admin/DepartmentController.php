<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Company;
use App\Country;
use App\Department;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function showList()
    {
        $departments = Department::all();
        return view('admin.department.show-list', compact('departments'));
    }

    public function create()
    {
        $countries = Country::all();
        $companies = Company::all();
        return view('admin.department.create', compact('countries', 'companies'));
    }

    public function update($id)
    {
        $department = Department::findOrFail($id);
        $companies = Company::all();
        $countries = Country::all();
        $cities = City::where('country_id', $department->country_id)->get();
        return view('admin.department.update', compact('department', 'companies', 'countries', 'cities'));
    }

    public function postUpdate(Request $request, $id=null)
    {
        $inputs = $request->all();

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'company' => 'required|exists:companies,id',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id'
        ]);

        if($id) {
            $department = Department::findOrFail($id);
            $actionType = 'updated';
        } else {
            $department = New Department;
            $actionType = 'created';
        }

        $department->name = $inputs['name'];
        $department->description = $inputs['description'];
        $department->company_id = $inputs['company'];
        $department->country_id = $inputs['country'];
        $department->city_id = $inputs['city'];
        $department->save();

        return redirect()->route('admin-departments-list')->with(['message' => 'Department ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('admin-departments-list')->with(['message' => 'Department Deleted Successfully']);
    }
}
