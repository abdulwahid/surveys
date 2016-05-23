@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Surveys Taken</h1>
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
                                <th>Survey Taken ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date / Time</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($surveysTaken as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->user_name}}</td>
                                <td>{{$row->user_email}}</td>
                                <td>{{$row->role->name}}</td>
                                <td>{{$row->created_at}}</td>
                                <td><a href="{{ route('admin-generate-graph', ['survey_taken_id' => $row->id]) }}"> See Graph</a></td>
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