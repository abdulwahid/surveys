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

                        <div id="pc-utube-vdo">
                            <iframe width="520" height="315" src="https://www.youtube.com/embed/P0ia7qlW3y0" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div id="tablet-utube-vdo" style="display: none">
                            <iframe width="520" height="315" src="https://www.youtube.com/embed/pUlbw4_IJks" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-lg btn-success next">Next</button>
                    </div>
                </div>

                <div class="login-panel panel panel-default user-info" style="display:none;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Important instructions:</h3>
                    </div>
                    <div class="panel-body">
                        <p>This survey consists of multiple statements.</p>
                        <p>Each Statement has 5-7 possible endings.</p>
                        <p>Order the endings of these Statements by reordering them.</p>
                        <p>Drag each statement to where you would like it to show in the order you want.</p>
                        <p>Order them from <b>most like you</b> to <b>least like you</b> from <b>top</b> to <b>bottom</b> respectively.</p>
                        <p>Where the most like you is at the top, and least like you is at the bottom.</p>
                        <p><b>There is no right or wrong, there is just your preferred order.</b></p>
                        <p><b>If you get stuck, go with your first instinct. It is likely the right one for you.</b></p>
                        <br>
                        <p><b>NOTE:</b> If the order you see is already as you would want it, then pressing next a second time will move you to the next statement.</p>
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

        <div id="confirm-next" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            You have not changed any option.
                            If the order you see is already as you would want it, then press next again to move to next statement.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@endsection