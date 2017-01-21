<?php

namespace App\Http\Requests;

/**
 * Class CalculationRequest
 * @package App\Http\Requests
 */
class CalculationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstOperand' => 'required|numeric',
            'secondOperand' => 'required|numeric',
        ];

    }

    /**
     * Contains all the messages that will be displayed if validation fails
     * @return array
     */
    public function messages()
    {
        return [
            'firstOperand.required' => ':field is required',
            'secondOperand.required' => ':field is required',
            'firstOperand.numeric' => ':field must be numeric',
            'secondOperand.numeric' => ':field must be numeric',
        ];
    }
}
