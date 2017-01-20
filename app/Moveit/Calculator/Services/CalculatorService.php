<?php

namespace App\Moveit\Calculator\Services;

use Config;

/**
 * Class CalculatorService
 * @package Moveit\Calculator
 */
class CalculatorService
{
    public function __construct()
    {

    }

    /**
     * @param $operation
     * @param $firstOperand
     * @param $secondOperand
     *
     * @return float|string
     */
    public function calculate($operation, $firstOperand, $secondOperand)
    {
        switch ($operation) {
            case "add":
                return $firstOperand + $secondOperand;
                break;

            case "subtract":
                return $firstOperand - $secondOperand;
                break;

            case "multiply":
                return $firstOperand * $secondOperand;
                break;

            case "divide":
                if ($secondOperand == 0) {
                    throw new \InvalidArgumentException('Not a number');
                }
                return $firstOperand / $secondOperand;
                break;

            default:
                return null;
        }
    }

    /**
     * @return array
     */
    public function getOperandSymbols()
    {
        return [
            'add' => Config::get('calculator.operation.add'),
            'subtract' => Config::get('calculator.operation.subtract'),
            'multiply' => Config::get('calculator.operation.multiply'),
            'divide' => Config::get('calculator.operation.divide'),
        ];
    }

}
