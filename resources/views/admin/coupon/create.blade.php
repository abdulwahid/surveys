@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Coupon</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-coupons-post-update') }}" method="post">
                            <div class="form-group {{ ($errors && $errors->has('company')) ? 'has-error' : '' }}">
                                <label>Company</label>
                                <select name="company" class="form-control">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ (old('company') && old('company') == $company->id) ? 'selected' : ''}}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('company')) ? '<p class="help-block">'. $errors->first('company') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('department')) ? 'has-error' : '' }}">
                                <label>Department</label>
                                <select name="department" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ (old('department') && old('department') == $department->id) ? 'selected' : ''}}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('department')) ? '<p class="help-block">'. $errors->first('department') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('role')) ? 'has-error' : '' }}">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ (old('role') && old('role') == $role->id) ? 'selected' : ''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('role')) ? '<p class="help-block">'. $errors->first('role') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('coupon')) ? 'has-error' : '' }}">
                                <label>Coupon</label>
                                <input name="coupon" class="form-control" value="{{ (old('coupon')) ? old('coupon') : '' }}">
                                {!! ($errors && $errors->has('coupon')) ? '<p class="help-block">'. $errors->first('coupon') .'</p>' : '' !!}
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-coupons-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection