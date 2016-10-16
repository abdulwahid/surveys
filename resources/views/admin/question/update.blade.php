@extends('layouts.admin')

@section('content')

<div> class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Question</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="{{ route('admin-questions-post-update', $question->id) }}" method="post">

                            <div class="form-group {{ ($errors && $errors->has('category')) ? 'has-error' : '' }}">
                                <label>Category</label>
                                <select name="category" class="country form-control">
                                    <option value="">Select Category</option>
                                    <?php $selectedCategory = (old('category') ? old('category') : $question->category_id); ?>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $selectedCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                {!! ($errors && $errors->has('category')) ? '<p class="help-block">'. $errors->first('category') .'</p>' : '' !!}
                            </div>
                            <div class="form-group {{ ($errors && $errors->has('text')) ? 'has-error' : '' }}">
                                <label>Text</label>
                                <input name="text" class="form-control" value="{{ (old('text')) ? old('text') : $question->text }}">
                                {!! ($errors && $errors->has('text')) ? '<p class="help-block">'. $errors->first('text') .'</p>' : '' !!}
                            </div>

                            <div class="form-group {{ ($errors && $errors->has('sort_order')) ? 'has-error' : '' }}">
                                <label>Sort Order</label>
                                <input name="sort_order" class="form-control" value="{{ (old('sort_order')) ? old('sort_order') : $question->sort_order }}">
                                {!! ($errors && $errors->has('sort_order')) ? '<p class="help-block">'. $errors->first('sort_order') .'</p>' : '' !!}
                            </div>
                            {{ csrf_field()  }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-questions-list') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection