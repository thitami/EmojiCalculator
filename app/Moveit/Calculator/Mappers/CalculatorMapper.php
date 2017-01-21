<?php

namespace App\Moveit\Calculator\Mappers;

use App\Moveit\Calculator\Models\Calculator;

/**
 * Class CalculatorMapper
 * @package App\Moveit\Calculator\Mappers
 */
class CalculatorMapper
{
    /**
     * @param array $request
     * @return Calculator
     */
    public function toEntity($request)
    {
        $calculator = new Calculator();
        $calculator->setFirstOperand($request['firstOperand']);
        $calculator->setSecondOperand($request['secondOperand']);
        $calculator->setOperation($request['operation']);

        return $calculator;
    }
}