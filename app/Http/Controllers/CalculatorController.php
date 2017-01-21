<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculationRequest;
use App\Moveit\Calculator\Services\CalculatorService;

/**
 * Class CalculatorController
 * @package App\Http\Controllers
 */
class CalculatorController extends Controller
{
    /**
     * @var CalculatorService
     */
    protected $calculatorService;

    /**
     * CalculatorController constructor.
     * @param CalculatorService $calculatorService
     */
    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function homepage()
    {
        return view('calculator.home', ['symbols' => $this->calculatorService->getOperandSymbols()]);
    }

    /**
     * @param CalculationRequest $calculationRequest
     * @return float|string
     */
    public function getResult(CalculationRequest $calculationRequest)
    {
        try {
            $result = $this->calculatorService->calculate(
                $calculationRequest->all()
            );

        } catch (\InvalidArgumentException $invalidArgumentException) {
            return $invalidArgumentException->getMessage();
        }

        return ($result === null) ? 'Invalid operator supplied' : $result;
    }
}
