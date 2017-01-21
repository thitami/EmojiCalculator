<?php

namespace App\Moveit\Calculator\Services;

use App\Moveit\Calculator\Mappers\CalculatorMapper;
use App\Moveit\Calculator\Models\Calculator;
use Config;

/**
 * Class CalculatorService
 * @package Moveit\Calculator
 */
class CalculatorService
{
    /**
     * @var Calculator
     */
    protected $calculator;

    /**
     * @var CalculatorMapper
     */
    protected $calculatorMapper;

    /**
     * CalculatorService constructor.
     * @param Calculator $calculator
     * @param CalculatorMapper $calculatorMapper
     */
    public function __construct(Calculator $calculator, CalculatorMapper $calculatorMapper)
    {
        $this->calculator = $calculator;
        $this->calculatorMapper = $calculatorMapper;
    }

    /**
     * Calculate calls CalculatorMapper to convert the passed array to proper Calculator model and
     * perform the suitable operation between the operands.
     *
     * @param array $request
     *
     * @return float|null
     */
    public function calculate(array $request)
    {
        $calculator = $this->calculatorMapper->toEntity($request);

        switch ($calculator->getOperation()) {
            case "add":
                return $calculator->getFirstOperand() + $calculator->getSecondOperand();
                break;

            case "subtract":
                return $calculator->getFirstOperand() - $calculator->getSecondOperand();
                break;

            case "multiply":
                return $calculator->getFirstOperand() * $calculator->getSecondOperand();
                break;

            case "divide":
                if ($calculator->getSecondOperand() == 0) {
                    throw new \InvalidArgumentException('Not a number');
                }

                return $calculator->getFirstOperand() / $calculator->getSecondOperand();
                break;

            default:
                return null;
        }
    }

    /**
     * Checks if there are any duplicate symbols supplied and if yes, it loads the defaults
     * Otherwise, it loads the configured operand symbols.
     *
     * @return array
     */
    public function getOperandSymbols()
    {
        return (!$this->duplicateSymbolExists(
            $operationsConfig = Config::get('calculator.operation')
        )) ? $operationsConfig
            : Config::get('calculator.defaults');
    }

    /**
     * Checks whether there is a duplicate symbol in the array
     *
     * @param $calculatorConfig
     * @return bool
     */
    private function duplicateSymbolExists($calculatorConfig)
    {
        return count($calculatorConfig) !== count(array_unique($calculatorConfig));
    }
}
