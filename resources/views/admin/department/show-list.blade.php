@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <h1 class="page-header">Departments</h1>
            </div>
            <div class="col-lg-6">
                <a class="btn btn-primary pull-right page-header" role="button" href="{{ route('admin-departments-create') }}">Add New Department</a>
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
                                <th>Company</th>
                                <th>Country</th>
                                <th>City</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{$row->company->name}}</td>
                                <td>{{$row->country->name}}</td>
                                <td>{{$row->city->name}}</td>
                                <td>
                                    <a href="{{ route('admin-departments-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    &nbsp;|&nbsp;
                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-departments-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
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