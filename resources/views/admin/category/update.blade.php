@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Category "{{ $category->name }}"</h1>
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
                        <form role="form" action="{{ route('admin-categories-post-update', $category->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : $category->name }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <input name="description" class="form-control" value="{{ (old('description')) ? old('description') : $category->description }}">
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('sort_order')) ? 'has-error' : '' }}">
                                <label>Sort Order</label>
                                <input name="sort_order" class="form-control" value="{{ (old('sort_order')) ? old('sort_order') : $category->sort_order }}">
                                {!! ($errors && $errors->has('sort_order')) ? '<p class="help-block">'. $errors->first('sort_order') .'</p>' : '' !!}
                            </div>

                            {{ csrf_field()  }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-categories-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection