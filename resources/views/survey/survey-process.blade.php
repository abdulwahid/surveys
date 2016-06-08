@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="survey-container col-md-6 col-md-offset-3" data-coupon-id="{{ $surveyData->id  }}">
                <div class="login-panel panel panel-default user-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please provide following information!</h3>
                    </div>
                    <div class="panel-body">
                        <fieldset>
                            <div class="alert alert-danger error-message" style="display: none;"></div>
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control user-name" name="name" type="text" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control user-email" name="email" required type="email">
                            </div>
                            @if($surveyData->role)
                                <input type="hidden" class="role" name="role" value="{{ $surveyData->role->id }}">
                            @else
                                <div class="form-group">
                                    <label>Role</label>
                                    {{ Form::select('role', $roles, null, ['class' => 'role']) }}
                                </div>
                            @endif
                            {{ csrf_field() }}
                        </fieldset>
                        <div class="form-group text-center">
                            <button class="btn btn-lg btn-success next">Next</button>
                        </div>
                    </div>
                </div>
                <div class="login-panel panel panel-default user-info" style="display:none;">
                    <div class="panel-body">
                        <iframe width="520" height="315" src="https://www.youtube.com/embed/F9XybBpSqoI" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-lg btn-success next">Next</button>
                    </div>
                </div>

                <div class="login-panel panel panel-default user-info" style="display:none;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Instructions</h3>
                    </div>
                    <div class="panel-body">
                        Instructions coming soon...
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-lg btn-success next">Next</button>
                    </div>
                </div>
                <?php
                $surveysCount = count($surveyData->surveys);
                $s = 0;
                $traitsQuestionsCount = [];
                ?>
                @foreach($surveyData->surveys as $survey)
                    <?php
                    $s++;
                    $questionsCount = count($survey->questions);
                    $q = 0;
                    ?>
                    @foreach($survey->questions as $question)
                        <?php $q++; ?>
                            <div class="login-panel panel panel-default question-container" data-question-id="{{ $question->id }}" data-category-id="{{ $question->category_id }}" style="display:none;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        {{ $question->text }}
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="answers-container">
                                        <?php
                                            $i = count($question->answers);
                                            $traitsCount = [];
                                        ?>
                                        @foreach($question->answers as $answer)
                                            <div class="answer" data-answer-id="{{ $answer->id }}" data-trait-id="{{ $answer->trait_id }}">
                                                {{ $answer->text }}
                                            </div>
                                            <?php
                                                $i--;
                                                if($answer->trait_id){
                                                    $traitsCount[$answer->trait_id] = $answer->trait_id;
                                                    $traitsQuestionsCount[$answer->trait_id][$question->id] = $question->id;
                                                }
                                            ?>
                                        @endforeach
                                            <input type="hidden" class="traits-count" value="{{  count($traitsCount) }}">
                                    </div>
                                    <div class="form-group text-center">
                                        @if($questionsCount == $q && $surveysCount == $s)
                                            <button class="btn btn-lg btn-danger finish">Finish</button>
                                        @else
                                            <button class="btn btn-lg btn-success next">Next</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endforeach

                @foreach($traitsQuestionsCount as $trait_id => $questions)
                    <input type="hidden" id="traits-{{ $trait_id }}-questions" value="{{ count($questions) }}">
                @endforeach

            </div>
        </div>
    </div>
@endsection