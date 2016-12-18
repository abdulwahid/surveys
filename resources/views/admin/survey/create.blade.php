@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Survey</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" action="{{ route('admin-surveys-post-update') }}" method="post">
                            <div class="col-lg-6">
                                <div class="form-group {{ ($errors && $errors->has('survey_type')) ? 'has-error' : '' }}">
                                    <label>Survey Type</label>
                                    <select name="survey_type" class="form-control">
                                        <option value="">Select Survey Type</option>
                                        @foreach($surveyTypes as $surveyType)
                                            <option value="{{ $surveyType->id }}" {{ (old('survey_type') && old('survey_type') == $surveyType->id) ? 'selected' : ''}}>{{ $surveyType->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! ($errors && $errors->has('survey_type')) ? '<p class="help-block">'. $errors->first('survey_type') .'</p>' : '' !!}
                                </div>
                                <div class="form-group {{ ($errors && $errors->has('title')) ? 'has-error' : '' }}">
                                    <label>Title</label>
                                    <input name="title" class="form-control" value="{{ (old('title')) ? old('title') : '' }}">
                                    {!! ($errors && $errors->has('title')) ? '<p class="help-block">'. $errors->first('title') .'</p>' : '' !!}
                                </div>

                                <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ (old('description')) ? old('description') : '' }}</textarea>
                                    {!! ($errors && $errors->has('description')) ? '<p class="help-block">'. $errors->first('description') .'</p>' : '' !!}
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#coupons">Attach / Detach Coupons</a>
                                            </h4>
                                        </div>
                                        <div id="coupons" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                @foreach($coupons as $coupon)
                                                    <label class="checkbox-inline">
                                                        <input name="coupons[]" value="{{ $coupon->id }}" type="checkbox">
                                                        {{ $coupon->coupon }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#questions">Attach / Detach Questions</a>
                                            </h4>
                                        </div>
                                        <div id="questions" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                @foreach($questions as $question)
                                                    <label class="checkbox">
                                                        <input name="questions[]" value="{{ $question->id }}" type="checkbox">
                                                        {{ $question->text }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a class="btn btn-default" role="button" href="{{ route('admin-survey-types-list') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection