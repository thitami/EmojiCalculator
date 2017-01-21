<?php

// Returns an array keyed by 'operation' containing the symbols that are assigned to each operation
return [

    'operation' => [
        'add' => getenv('CALCULATOR_ADD_OPERAND'),
        'subtract' => getenv('CALCULATOR_SUBTRACT_OPERAND'),
        'multiply' => getenv('CALCULATOR_DIVIDE_OPERAND'),
        'divide' => getenv('CALCULATOR_MULTIPLY_OPERAND'),
    ],

    // we are loading defaults if any duplicates found in operation
    'defaults' => [
        'add' => '&#128125;',
        'subtract' => '&#128128;',
        'multiply' => '&#128123;',
        'divide' => '&#128561;',
    ],
];
