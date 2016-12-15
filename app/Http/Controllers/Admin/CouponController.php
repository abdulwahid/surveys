<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Coupon;
use App\Department;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function showList()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.show-list', compact('coupons'));
    }

    public function create()
    {
        $companies = Company::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('admin.coupon.create', compact('companies', 'departments', 'roles'));
    }

    public function update($id)
    {
        $coupon = Coupon::findOrFail($id);
        $companies = Company::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('admin.coupon.update', compact('coupon', 'companies', 'departments', 'roles'));
    }

    public function postUpdate(Request $request, $id=null)
    {

        $validations = [
            'coupon' => 'required|unique:coupons,coupon',
            'company' => 'required|exists:companies,id',
            'department' => 'required|exists:departments,id',
            'role' => 'required|exists:roles,id'
        ];

        if($id) {
            $coupon = Coupon::findOrFail($id);
            $actionType = 'updated';

            if($coupon->coupon == $request->get('coupon')) {
                $validations['coupon'] = 'required';
            }

        } else {
            $coupon = New Coupon;
            $actionType = 'created';
        }

        $this->validate($request, $validations);

        $coupon->coupon = $request->get('coupon');
        $coupon->company_id = $request->get('company');
        $coupon->department_id = $request->get('department');
        $coupon->role_id = $request->get('role');
        $coupon->save();

        return redirect()->route('admin-coupons-list')->with(['message' => 'Coupon ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('admin-coupons-list')->with(['message' => 'Coupon Deleted Successfully']);
    }
}
