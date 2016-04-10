@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <?php if (Session::has('error_message')) { ?>
                    <div class="alert alert-danger">
                        {{  Session::get('error_message') }}
                    </div>
                <?php } ?>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please provide coupon</h3>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'start-survey','method' =>'post']) !!}
                            <fieldset>
                                <div class="form-group">
                                    <label>Coupon</label>
                                    <input class="form-control coupon" name="coupon" required type="text">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                {!! Form::submit('Start Survey', ['class' => 'btn btn-lg btn-success btn-block']) !!}
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection