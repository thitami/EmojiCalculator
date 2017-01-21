@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Emoji Calculator</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                {!! Form::open() !!}
                                <input type="text" name="output" id="calc-output" class="form-control" readonly>
                                <input type="text" name="firstOperand" id="firstOperand" class="form-control operand"
                                       placeholder="Operand 1" autocomplete="off">

                                <div class='form-group{{ $errors->has("contestTypeId") ? ' has-error' : '' }}'>
                                    {!! Form::select('operation', $symbols, 4, ['class' => 'form-control', 'id'=> 'operation']) !!}

                                    {!! $errors->first("operandID", '<span class="help-block">:message</span>') !!}
                                </div>
                                <input type="text" name="secondOperand" id="secondOperand" class="form-control operand"
                                       placeholder="Operand 2" autocomplete="off">

                                <div class="box-footer text-center">
                                    <button class="btn btn-warning btn-flat" id="reset-calc" name="button"
                                            type="reset"> Reset
                                    </button>

                                    <button class="btn col-lg-5 btn-flat pull-right" id="submit-calc"
                                            type="submit" name="doCalculate">
                                        =
                                    </button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-3">
                                <div id="error-msg"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
