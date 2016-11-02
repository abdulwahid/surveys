@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Survey Type</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-survey-types-post-update') }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : '' }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}

                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <input name="description" class="form-control" value="{{ (old('description')) ? old('description') : '' }}">
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-survey-types-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection