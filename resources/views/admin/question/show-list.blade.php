@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <h1 class="page-header">Questions</h1>
                </div>
                <div class="col-lg-3">
                    <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-questions-create') }}">Add New Question</a>
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
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover dataTables">
                            <thead>
                            <tr>
                                <th>Text</th>
                                <th>Category</th>
                                <th>Sort Order</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $row)
                            <tr>
                                <td title="{{ $row->text }}">{{str_limit($row->text, 100)}}</td>
                                <td>{{$row->category->name}}</td>
                                <td>{{$row->sort_order}}</td>
                                <td>
                                    <a href="{{ route('admin-questions-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-questions-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                    &nbsp;|&nbsp;
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $row->id }}-modal">See Answers</a>
                                    <div class="modal fade" id="{{ $row->id }}-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Answers</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        @if($row->answers->count())
                                                            <thead>
                                                            <tr>
                                                                <th>Text</th>
                                                                <th>Trait</th>
                                                                <th>Sort Order</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach($row->answers as $answer)
                                                                    <tr>
                                                                        <td title="{{ $answer->text }}">{{str_limit($answer->text, 100)}}</td>
                                                                        <td>{{($answer->traits) ? $answer->traits->name : ''}}</td>
                                                                        <td>{{$answer->sort_order}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @else
                                                            <tr><td colspan="3">No Answer found for this Question.</td></tr>
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