<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Company;
use App\Country;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function showList()
    {
        $companies = Company::all();
        return view('admin.company.show-list', compact('companies'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.company.create', compact('countries'));
    }

    public function update($id)
    {
        $company = Company::findOrFail($id);
        $countries = Country::all();
        $cities = City::where('country_id', $company->country_id)->get();
        return view('admin.company.update', compact('company', 'countries', 'cities'));
    }

    public function postUpdate(Request $request, $id=null)
    {
        $this->validate($request, [
            'name' => 'required',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id'
        ]);

        if($id) {
            $company = Company::findOrFail($id);
            $actionType = 'updated';
        } else {
            $company = New Company;
            $actionType = 'created';
        }

        $company->name = $request->get('name');
        $company->description = $request->get('description', '');
        $company->country_id = $request->get('country');
        $company->city_id = $request->get('city');
        $company->save();

        return redirect()->route('admin-companies-list')->with(['message' => 'Company ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('admin-companies-list')->with(['message' => 'Company Deleted Successfully']);
    }
}
