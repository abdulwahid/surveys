@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Question</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
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


                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" role="button" href="{{ route('admin-questions-list') }}">Cancel</a>
                        </form>
                    </div>
                    <div class="col-lg-7">
                        <div class="panel panel-default questions-answers">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Manage Answers
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Text</th>
                                            <th>Trait</th>
                                            <th>Sort Order</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($question->answers as $answer)
                                            <tr class="answer-tr">
                                                <td class="text" title="{{ $answer->text }}">{{str_limit($answer->text, 100)}}</td>
                                                <td class="trait" data-trait-id="{{ $answer->trait_id }}">{{($answer->traits) ? $answer->traits->name : ''}}</td>
                                                <td class="sort_order">{{$answer->sort_order}}</td>
                                                <td>
                                                    <a href="{{ route('admin-answers-post-update', $answer->id) }}" class="show-answer-modal update"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    &nbsp;|&nbsp;
                                                    <a onclick="confirm('Are you sure you want to delete?');" href="{{ route('admin-answers-delete', $answer->id) }}"><span class="glyphicon glyphicon-trash"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="btn btn-success show-answer-modal create" role="button" href="{{ route('admin-answers-post-update') }}">Add New Answer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="answer-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <form role="form" method="post" class="answer-modal-form">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title answer-modal-heading">Create Answer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Trait</label>
                                            <select name="answer_trait" class="trait form-control">
                                                <option value="">Select Trait</option>
                                                @foreach($traits as $trait)
                                                    <option value="{{ $trait->id }}">{{ $trait->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Text</label>
                                            <input required name="answer_text" class="text form-control" value="">
                                        </div>

                                        <div class="form-group">
                                            <label>Sort Order</label>
                                            <input name="sort_order" class="sort_order form-control" value="1">
                                        </div>
                                        <input type="hidden" name="answer_question" class="question form-control" value="{{ $question->id }}">
                                        {{ csrf_field() }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary answer-modal-submit">Create</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection