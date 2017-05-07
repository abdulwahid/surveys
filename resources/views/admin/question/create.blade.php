@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Question</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-questions-post-update') }}" method="post">
                            <div class="form-group {{ ($errors && $errors->has('category')) ? 'has-error' : '' }}">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category') && old('category') == $category->id) ? 'selected' : ''}}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('category')) ? '<p class="help-block">'. $errors->first('category') .'</p>' : '' !!}
                            </div>
                            <div id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#surveys">Surveys Association</a>
                                        </h4>
                                    </div>
                                    <div id="surveys" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            @foreach($surveys as $survey)
                                                <label class="checkbox-inline">
                                                    <input name="surveys[]" value="{{ $survey->id }}" type="checkbox">
                                                    {{ $survey->title }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('text')) ? 'has-error' : '' }}">
                                <label>Text</label>
                                <input name="text" class="form-control" value="{{ (old('text')) ? old('text') : '' }}">
                                {!! ($errors && $errors->has('text')) ? '<p class="help-block">'. $errors->first('text') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('sort_order')) ? 'has-error' : '' }}">
                                <label>Sort Order</label>
                                <input name="sort_order" class="form-control" value="{{ (old('sort_order')) ? old('sort_order') : $maxQuestionOrder + 1 }}">
                                {!! ($errors && $errors->has('sort_order')) ? '<p class="help-block">'. $errors->first('sort_order') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-questions-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection