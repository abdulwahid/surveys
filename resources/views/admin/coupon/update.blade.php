@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Coupon</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" action="{{ route('admin-coupons-post-update', $coupon->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('company')) ? 'has-error' : '' }}">
                                <label>Company</label>
                                <select name="company" class="country form-control">
                                    <option value="">Select Company</option>
                                    <?php $selectedCompany = (old('company') ? old('company') : $coupon->company_id); ?>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $selectedCompany ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('company')) ? '<p class="help-block">'. $errors->first('company') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('department')) ? 'has-error' : '' }}">
                                <label>Department</label>
                                <select name="department" class="form-control">
                                    <option value="">Select Department</option>
                                    <?php $selectedDepartment = (old('department') ? old('department') : $coupon->department_id); ?>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $department->id == $selectedDepartment ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('department')) ? '<p class="help-block">'. $errors->first('department') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('role')) ? 'has-error' : '' }}">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="">Select Role</option>
                                    <?php $selectedRole = (old('role') ? old('role') : $coupon->role_id); ?>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $selectedRole ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('role')) ? '<p class="help-block">'. $errors->first('role') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('coupon')) ? 'has-error' : '' }}">
                                <label>Coupon</label>
                                <input name="coupon" class="form-control" value="{{ (old('coupon')) ? old('coupon') : $coupon->coupon }}">
                                {!! ($errors && $errors->has('coupon')) ? '<p class="help-block">'. $errors->first('coupon') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-coupons-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection