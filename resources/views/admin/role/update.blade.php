@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Role "{{ $role->name }}"</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-roles-post-update', $role->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : $role->name }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ (old('description')) ? old('description') : $role->description }}</textarea>
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field()  }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-roles-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection