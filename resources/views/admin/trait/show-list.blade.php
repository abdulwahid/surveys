@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <h1 class="page-header">Traits</h1>
            </div>
            <div class="col-lg-3">
                <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-traits-create') }}">Add New Trait</a>
            </div>
            <div class="col-lg-3">
                <select id="list-survey-selector" name="survey_id" class="page-header form-control">
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
                                <th>Category</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($traits as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{$row->category->name}}</td>
                                <td>
                                    <a href="{{ route('admin-traits-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-traits-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                    &nbsp;|&nbsp;
                                    <a href="{{ route('admin-answers-list', $row->id) }}">See Answers</a>
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