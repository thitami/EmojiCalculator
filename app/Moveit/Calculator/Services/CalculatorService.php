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

    public function getOperandSymbols()
    {
        return ['&#128125;', '&#128128;', '&#128123;', '&#128561;'];
    }

}
