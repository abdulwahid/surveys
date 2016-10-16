@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Department  "{{ $department->name }}"</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-departments-post-update', $department->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('company')) ? 'has-error' : '' }}">
                                <label>Company</label>
                                <select name="company" class="form-control">
                                    <option value="">Select Company</option>
                                    <?php $selectedCompany = (old('company') ? old('company') : $department->company_id); ?>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $selectedCompany ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('company')) ? '<p class="help-block">'. $errors->first('company') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : $department->name }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <input name="description" class="form-control" value="{{ (old('description')) ? old('description') : $department->description }}">
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('country')) ? 'has-error' : '' }}">
                                <label>Country</label>
                                <select name="country" class="country form-control">
                                    <option value="">Select Country</option>
                                    <?php $selectedCountry = (old('country') ? old('country') : $department->country_id); ?>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $country->id == $selectedCountry ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('country')) ? '<p class="help-block">'. $errors->first('country') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('city')) ? 'has-error' : '' }}">
                                <label>City</label>
                                <select name="city" class="city form-control">
                                    <option value="">Select City</option>
                                    <?php $selectedCity = (old('city') ? old('city') : $department->city_id); ?>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id == $selectedCity ? 'selected' : '' }} >{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('city')) ? '<p class="help-block">'. $errors->first('city') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-departments-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection