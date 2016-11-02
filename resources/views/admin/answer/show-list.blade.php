@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Answers {{ ($trait) ? 'for Trait "' . $trait->name . '"' : ''}}</h1>
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
                                <th>Trait</th>
                                <th>Question</th>
                                <th>Sort Order</th>
                                {{--<th></th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($answers as $row)
                            <tr>
                                <td title="{{ $row->text }}">{{ str_limit($row->text, 100) }}</td>
                                <td>{{ ($row->traits) ? $row->traits->name : '' }}</td>
                                <td title="{{ $row->question->text }}">{{ str_limit($row->question->text) }}</td>
                                <td>{{$row->sort_order}}</td>
                                {{--<td>--}}
                                    {{--<a href="{{ route('admin-answers-update', $row->id) }}"><span class="glyphicon glyphicon-pencil"></span></a>--}}
                                    {{--<a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-answers-delete', $row->id) }}"><span class="glyphicon glyphicon-trash"></span></a>--}}
                                {{--</td>--}}
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