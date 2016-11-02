@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <h1 class="page-header">Survey</h1>
                </div>
                <div class="col-lg-6">
                    <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-surveys-create') }}">Add New Survey</a>
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
                                <th>Title</th>
                                <th>Description</th>
                                <th>Survey Type</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($surveys as $row)
                            <tr>
                                <td>{{$row->title}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{$row->surveyType->name}}</td>
                                <td>
                                    <a href="{{ route('admin-surveys-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-surveys-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                    &nbsp;|&nbsp;
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $row->id }}-coupons-modal">See Coupons</a>
                                    &nbsp;|&nbsp;
                                    <div class="modal fade" id="{{ $row->id }}-coupons-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Coupons</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        @if($row->coupons->count())
                                                            <thead>
                                                            <tr>
                                                                <th>Coupon</th>
                                                                <th>Company</th>
                                                                <th>Department</th>
                                                                <th>Role</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($row->coupons as $coupon)
                                                                    <tr>
                                                                        <td>{{ $coupon->coupon }}</td>
                                                                        <td>{{ ($coupon->company) ? $coupon->company->name : '' }}</td>
                                                                        <td>{{ ($coupon->department) ? $coupon->department->name : '' }}</td>
                                                                        <td>{{ ($coupon->role) ? $coupon->role->name : '' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @else
                                                            <tr><td colspan="3">No Coupon found for this Survey.</td></tr>
                                                        @endif
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $row->id }}-questions-modal"> See Questions </a>
                                    <div class="modal fade" id="{{ $row->id }}-questions-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Questions</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        @if($row->questions->count())
                                                            <thead>
                                                            <tr>
                                                                <th>Text</th>
                                                                <th>Category</th>
                                                                <th>Sort Order</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($row->questions as $question)
                                                                <tr>
                                                                    <td title="{{ $question->text }}">{{ str_limit($question->text, 100) }}</td>
                                                                    <td>{{ $question->category->name }}</td>
                                                                    <td>{{ $question->sort_order }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        @else
                                                            <tr><td colspan="3">No Question found for this Survey.</td></tr>
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