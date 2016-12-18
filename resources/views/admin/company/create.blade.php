@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Company</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-companies-post-update') }}" method="post">
                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : '' }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ (old('description')) ? old('description') : '' }}</textarea>
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('country')) ? 'has-error' : '' }}">
                                <label>Country</label>
                                <select name="country" class="country form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ (old('country') && old('country') == $country->id) ? 'selected' : ''}}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('country')) ? '<p class="help-block">'. $errors->first('country') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('city')) ? 'has-error' : '' }}">
                                <label>City</label>
                                <select name="city" class="city form-control">
                                    <option value="">Select City</option>
                                </select>
                                {!! ($errors && $errors->has('city')) ? '<p class="help-block">'. $errors->first('city') .'</p>' : '' !!}
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-companies-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection