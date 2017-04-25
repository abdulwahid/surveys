@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <h1 class="page-header">Categories</h1>
            </div>
            <div class="col-lg-3">
                <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-categories-create') }}">Add New Category</a>
            </div>
            <div class="col-lg-3">
                <select id="category-survey-selector" name="survey_id" class="page-header form-control">
                    <option value="">Select Survey</option>
                    @foreach($surveys as $survey)
                        <option value="{{ $survey->id }}" {{ ($surveyId == $survey->id) ? 'selected' : ''}}>{{ $survey->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover dataTables">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Survey Type</th>
                                <th>Sort Order</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{$row->surveyType->name}}</td>
                                <td class="category-sort-order" data-category-id="{{$row->id}}">
                                    <span class="category-sort-order-show">
                                        <span class="category-sort-order-value">{{$row->sort_order}}</span>
                                        <a class="edit pl-10 cursor-pointer"><span title="Update Sort Order" class="glyphicon glyphicon-pencil"></span></a>
                                    </span>
                                    <span class="category-sort-order-edit" style="display: none;">
                                        <input class="sort-order-field form-control so-col-field" value="{{$row->sort_order}}">
                                        <button title="Save Changes" type="button" class="save btn btn-info btn-circle"><i class="fa fa-check"></i>
                                        <button title="Cancel" type="button" class="cancel btn btn-default btn-circle"><i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                    <span class="category-sort-order-saving" style="display: none;">Saving...</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin-categories-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-categories-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                    &nbsp;|&nbsp;
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $row->id }}-modal">See Traits</a>
                                    <div class="modal fade" id="{{ $row->id }}-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Traits</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        @if($row->traits->count())
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach($row->traits as $trait)
                                                                <tr>
                                                                    <td>{{ $trait->name }}</td>
                                                                    <td title="{{ $trait->description }}">{{str_limit($trait->description, 100)}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        @else
                                                            <tr><td colspan="3">No Trait found for this Category.</td></tr>
                                                        @endif
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection