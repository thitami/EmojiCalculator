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
                                <input type="text" name="firstOperand" class="form-control" placeholder="Operand 1">

                                <div class='form-group{{ $errors->has("contestTypeId") ? ' has-error' : '' }}'>
                                    {!! Form::select('contestTypeId', $symbols, null, ['class' => 'form-control', 'id'=> 'operandId']) !!}
                                    
                                    {!! $errors->first("operandID", '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="operationMenu"
                                            data-toggle="dropdown" aria-expanded="true">
                                        Operation
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">&#128125;</a>
                                        </li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">&#128128;</a>
                                        </li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">&#128123;</a>
                                        </li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">&#128561;</a>
                                        </li>
                                    </ul>
                                </div>
                                <input type="text" name="secondOperand" class="form-control" placeholder="Operand 2">

                            </div>
                            <div class="col-md-3">PLACEHOLDER</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
