@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Company  "{{ $company->name }}"</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" action="{{ route('admin-companies-post-update', $company->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : $company->name }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <input name="description" class="form-control" value="{{ (old('description')) ? old('description') : $company->description }}">
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('country')) ? 'has-error' : '' }}">
                                <label>Country</label>
                                <select name="country" class="country form-control">
                                    <option value="">Select Country</option>
                                    <?php $selectedCountry = (old('country') ? old('country') : $company->country_id); ?>
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
                                    <?php $selectedCity = (old('city') ? old('city') : $company->city_id); ?>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id == $selectedCity ? 'selected' : '' }} >{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('city')) ? '<p class="help-block">'. $errors->first('city') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field()  }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-companies-list') }}">Cancel</a>
                        </form>
                    </div>
                    <div class="col-lg-7">
                        <div class="panel panel-default companies-departments">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Manage Departments
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Country</th>
                                            <th>City</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($company->departments as $department)
                                            <tr class="department-tr">
                                                <td class="name">{{ $department->name }}</td>
                                                <td class="description" title="{{ $department->description }}">{{str_limit($department->description, 50)}}</td>
                                                <td class="country" data-country-id="{{ $department->country_id }}">{{ $department->country->name }}</td>
                                                <td class="city" data-city-id="{{ $department->city_id }}">{{ $department->city->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin-departments-post-update', $department->id) }}" class="show-department-modal update"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    &nbsp;|&nbsp;
                                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-departments-delete', $department->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="btn btn-success show-department-modal create" role="button" href="{{ route('admin-departments-post-update') }}">Add New Department</a>
                                </div>
                            </div>
                            <div class="modal fade" id="department-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form role="form" method="post" class="department-modal-form">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title department-modal-heading">Create New Department</h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input required name="name" class="name form-control" value="">
                                                </div>

                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input name="description" class="description form-control" value="">
                                                </div>

                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select name="country" class="country form-control">
                                                        <option value="">Select Country</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select name="city" class="city form-control">
                                                        <option value="">Select City</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <input type="hidden" name="company" class="company form-control" value="{{ $company->id }}">
                                                {{ csrf_field() }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary department-modal-submit">Create</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection