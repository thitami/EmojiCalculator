<?php

namespace App\Moveit\Calculator\Models;

/**
 * Class Calculator
 * @package App\Moveit\Calculator\Models
 */
class Calculator
{
    /**
     * @var float
     */
    protected $firstOperand;

    /**
     * @var float
     */
    protected $secondOperand;

    /**
     * @var string
     */
    protected $operation;

    /**
     * @return float
     */
    public function getFirstOperand()
    {
        return $this->firstOperand;
    }

    /**
     * @return float
     */
    public function getSecondOperand()
    {
        return $this->secondOperand;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param float $firstOperand
     * @return Calculator
     */
    public function setFirstOperand($firstOperand)
    {
        $this->firstOperand = $firstOperand;

        return $this;
    }

    /**
     * @param float $secondOperand
     * @return Calculator
     */
    public function setSecondOperand($secondOperand)
    {
        $this->secondOperand = $secondOperand;

        return $this;
    }

    /**
     * @param string $operation
     * @return Calculator
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

}