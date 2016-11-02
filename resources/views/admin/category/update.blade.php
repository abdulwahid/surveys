@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Category "{{ $category->name }}"</h1>
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
                        <form role="form" action="{{ route('admin-categories-post-update', $category->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('survey_type')) ? 'has-error' : '' }}">
                                <label>Survey Type</label>
                                <select name="survey_type" class="form-control">
                                    <option value="">Select Survey Type</option>
                                    <?php $selectedSurveyType = (old('survey_type') ? old('survey_type') : $category->survey_type_id); ?>
                                    @foreach($surveyTypes as $surveyType)
                                        <option value="{{ $surveyType->id }}" {{ $surveyType->id == $selectedSurveyType ? 'selected' : '' }}>{{ $surveyType->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('survey_type')) ? '<p class="help-block">'. $errors->first('survey_type') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : $category->name }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <input name="description" class="form-control" value="{{ (old('description')) ? old('description') : $category->description }}">
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('sort_order')) ? 'has-error' : '' }}">
                                <label>Sort Order</label>
                                <input name="sort_order" class="form-control" value="{{ (old('sort_order')) ? old('sort_order') : $category->sort_order }}">
                                {!! ($errors && $errors->has('sort_order')) ? '<p class="help-block">'. $errors->first('sort_order') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field()  }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-categories-list') }}">Cancel</a>
                        </form>
                    </div>
                    <div class="col-lg-7">
                        <div class="panel panel-default categories-traits">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Manage Traits
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($category->traits as $trait)
                                            <tr class="trait-tr">
                                                <td class="name">{{ $trait->name }}</td>
                                                <td class="description" title="{{ $trait->description }}">{{str_limit($trait->description, 100)}}</td>
                                                <td>
                                                    <a href="{{ route('admin-traits-post-update', $trait->id) }}" class="show-trait-modal update"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    &nbsp;|&nbsp;
                                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-traits-delete', $trait->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="btn btn-success show-trait-modal create" role="button" href="{{ route('admin-traits-post-update') }}">Add New Trait</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="trait-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <form role="form" method="post" class="trait-modal-form">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title trait-modal-heading">Create Trait</h4>
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

                                        <input type="hidden" name="category" class="category form-control" value="{{ $category->id }}">
                                        {{ csrf_field() }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary trait-modal-submit">Create</button>
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


@endsection