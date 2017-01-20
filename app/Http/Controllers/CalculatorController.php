<?php

namespace App\Http\Controllers;

use App\Moveit\Calculator\Services\CalculatorService;

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
}
