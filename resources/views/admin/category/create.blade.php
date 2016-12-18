@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Category</h1>
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
                        <form role="form" action="{{ route('admin-categories-post-update') }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('survey_type')) ? 'has-error' : '' }}">
                                <label>Survey Type</label>
                                <select name="survey_type" class="country form-control">
                                    <option value="">Select Survey Type</option>
                                    @foreach($surveyTypes as $surveyType)
                                        <option value="{{ $surveyType->id }}" {{ (old('survey_type') && old('survey_type') == $surveyType->id) ? 'selected' : ''}}>{{ $surveyType->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('survey_type')) ? '<p class="help-block">'. $errors->first('survey_type') .'</p>' : '' !!}
                            </div>


                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : '' }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}

                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="6">{{ (old('description')) ? old('description') : '' }}</textarea>
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('sort_order')) ? 'has-error' : '' }}">
                                <label>Sort Order</label>
                                <input name="sort_order" class="form-control" value="{{ (old('sort_order')) ? old('sort_order') : '1' }}">
                                {!! ($errors && $errors->has('sort_orders')) ? '<p class="help-block">'. $errors->first('sort_order') .'</p>' : '' !!}
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-categories-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection