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
                                <input type="text" name="output" id="output" class="form-control">
                                <input type="text" name="firstOperand" id="firstOperand" class="form-control" placeholder="Operand 1">

                                <div class='form-group{{ $errors->has("contestTypeId") ? ' has-error' : '' }}'>
                                    {!! Form::select('operation', $symbols, 4, ['class' => 'form-control', 'id'=> 'operation']) !!}

                                    {!! $errors->first("operandID", '<span class="help-block">:message</span>') !!}
                                </div>
                                <input type="text" name="secondOperand" id="secondOperand" class="form-control" placeholder="Operand 2">

                                <div class="box-footer">
                                    <button id="submit-calc" name="doCalculate"> = </button>
                                    <button class="btn btn-default btn-flat" name="button"
                                            type="reset"> Reset
                                    </button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-3">PLACEHOLDER</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
