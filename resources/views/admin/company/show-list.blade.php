@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <h1 class="page-header">Companies</h1>
            </div>
            <div class="col-lg-6">
                <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-companies-create') }}">Add New Company</a>
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
                                <th>Country</th>
                                <th>City</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{$row->country->name}}</td>
                                <td>{{$row->city->name}}</td>
                                <td>
                                    <a href="{{ route('admin-companies-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-companies-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                    &nbsp;|&nbsp;
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $row->id }}-modal">See Departments</a>
                                    <div class="modal fade" id="{{ $row->id }}-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Departments</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        @if($row->departments->count())
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                                <th>Country</th>
                                                                <th>City</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach($row->departments as $department)
                                                                <tr>
                                                                    <td>{{ $department->name }}</td>
                                                                    <td title="{{ $department->description }}">{{str_limit($department->description, 100)}}</td>
                                                                    <td>{{$department->country->name}}</td>
                                                                    <td>{{$department->city->name}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        @else
                                                            <tr><td colspan="3">No Department found for this Company.</td></tr>
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