@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <h1 class="page-header">Coupons</h1>
                </div>
                <div class="col-lg-6">
                    <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-coupons-create') }}">Add New Coupon</a>
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
                                <th>Coupon</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $row)
                            <tr>
                                <td >{{ $row->coupon }}</td>
                                <td>{{ $row->company->name }}</td>
                                <td>{{ $row->department->name }}</td>
                                <td>{{ $row->role->name }}</td>
                                <td>
                                    <a href="{{ route('admin-coupons-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-coupons-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                    &nbsp;|&nbsp;
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $row->id }}-surveys-modal">See Surveys</a>
                                    <div class="modal fade" id="{{ $row->id }}-surveys-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Surveys</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        @if($row->surveys->count())
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach($row->surveys as $survey)
                                                                    <tr>
                                                                        <td>{{ $survey->title }}</td>
                                                                        <td title="{{ $survey->description }}">{{str_limit($survey->description, 100)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @else
                                                            <tr><td colspan="3">No Survey found for this Coupon.</td></tr>
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