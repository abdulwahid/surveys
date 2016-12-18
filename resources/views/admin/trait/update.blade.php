@extends('layouts.admin')

@section('content')

<div> class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Trait  "{{ $trait->name }}"</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-traits-post-update', $trait->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('category')) ? 'has-error' : '' }}">
                                <label>Category</label>
                                <select name="category" class="country form-control">
                                    <option value="">Select Category</option>
                                    <?php $selectedCategory = (old('category') ? old('category') : $trait->category_id); ?>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $selectedCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('category')) ? '<p class="help-block">'. $errors->first('category') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('name')) ? 'has-error' : '' }}">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ (old('name')) ? old('name') : $trait->name }}">
                                {!! ($errors && $errors->has('name')) ? '<p class="help-block">'. $errors->first('name') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="6">{{ (old('description')) ? old('description') : $trait->description }}</textarea>
                                {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                            </div>
                            {{ csrf_field()  }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-traits-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection