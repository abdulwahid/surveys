@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Survey "{{ $survey->title }}"</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" action="{{ route('admin-surveys-post-update', $survey->id) }}" method="post">
                            <div class="col-lg-6">
                                <div class="form-group {{ ($errors && $errors->has('survey_type')) ? 'has-error' : '' }}">
                                    <label>Survey Type</label>
                                    <select name="survey_type" class="form-control">
                                        <option value="">Select Survey Type</option>
                                        <?php $selectedSurveyType = (old('survey_type') ? old('survey_type') : $survey->survey_type_id); ?>
                                        @foreach($surveyTypes as $surveyType)
                                            <option value="{{ $surveyType->id }}" {{ $surveyType->id == $selectedSurveyType ? 'selected' : '' }}>{{ $surveyType->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! ($errors && $errors->has('survey_type')) ? '<p class="help-block">'. $errors->first('survey_type') .'</p>' : '' !!}
                                </div>
                                <div class="form-group {{ ($errors && $errors->has('title')) ? 'has-error' : '' }}">
                                    <label>Title</label>
                                    <input name="title" class="form-control" value="{{ (old('title')) ? old('title') : $survey->title }}">
                                    {!! ($errors && $errors->has('title')) ? '<p class="help-block">'. $errors->first('title') .'</p>' : '' !!}
                                </div>

                                <div class="form-group {{ ($errors && $errors->has('description')) ? 'has-error' : '' }}">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ (old('description')) ? old('description') : $survey->description }}</textarea>
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
                                                <div class="form-group">
                                                    @foreach($coupons as $coupon)
                                                        <label class="checkbox-inline">
                                                            <?php
                                                            $checked = '';
                                                            $surveyCouponIds = $survey->coupons->keyBy('id');
                                                            if($surveyCouponIds->has($coupon->id)) {
                                                                $checked = 'checked="checked"';
                                                            }
                                                            ?>
                                                            <input name="coupons[]" value="{{ $coupon->id }}" {{ $checked }} type="checkbox">
                                                            {{ $coupon->coupon }}
                                                        </label>
                                                    @endforeach
                                                </div>
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
                                                <div class="form-group">
                                                    @foreach($questions as $question)
                                                        <div class="checkbox">
                                                            <label>
                                                                <?php
                                                                $checked = '';
                                                                $surveyQuestionIds = $survey->questions->keyBy('id');
                                                                if($surveyQuestionIds->has($question->id)) {
                                                                    $checked = 'checked="checked"';
                                                                }
                                                                ?>
                                                                <input name="questions[]" value="{{ $question->id }}" {{ $checked }} type="checkbox">
                                                                {{ $question->text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-default" role="button" href="{{ route('admin-surveys-list') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection