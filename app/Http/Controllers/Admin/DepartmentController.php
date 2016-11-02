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
        $this->validate($request, [
            'name' => 'required',
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

        $department->name = $request->input('name');
        $department->description = $request->input('description', '');
        $department->company_id = $request->input('company');
        $department->country_id = $request->input('country');
        $department->city_id = $request->input('city');
        $department->save();

        return redirect()->back()->with(['message' => 'Department ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->back()->with(['message' => 'Department deleted successfully']);
    }
}
