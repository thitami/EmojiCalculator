<?php

namespace Jupix\Contact\Validators;

use Jupix\Validators\AbstractLaravelValidator;
use Jupix\Validators\ValidableInterface;
use Config;

/**
 * Class CreateContactValidator
 * @package Jupix\MyPropertyFile\Validators
 */
class CreateContactValidator extends AbstractLaravelValidator implements ValidableInterface
{
    /**
     * @var string
     */
    protected $customFieldConnection = 'jupix_branch_custom_field';

    /**
     * CreateContactValidator constructor.
     * @param $validator
     */
    public function __construct($validator)
    {
        $this->messages['people.forename.required'] = 'The forename field is required.';
        $this->messages['people.surname.required'] = 'The surname field is required.';
        $this->messages['people.primaryContact.required'] = 'The primaryContact field is required.';
        $this->messages['people.primaryContact.numeric'] = 'The primaryContact value must be integer.';
        $this->messages['people.primaryContact.in'] = 'The primaryContact value value must be 0 or 1.';

        parent::__construct($validator);
    }

    /**
     * Validation for adding a new Contact
     *
     * @var array
     */
    protected $rules = array(
        'emailAddress' => array('required', 'email'),
        'contactType1' => array('required_with:contactNumber1', 'in:Work,Mobile,Home,Office'),
        'contactNumber1' => array('required'),
        'people' => array('required', 'array', 'primary_unique'),
    );

    /**
     * Validation messages
     *
     * @var array
     */
    protected $messages = array(
        'emailAddress.required' => 'The emailAddress field is required.',
        'emailAddress.email' => 'The emailAddress value must be a valid email address.',
        'people.array' => 'The people field must be an array with at least one person.',
        'people.required' => 'The people field is required and needs to be an array with at least one person.',
        'people.country.exists' => 'This is not a known country',
        'contactType1.required_with' => 'The contactType1 field is required with contactNumber1.',
        'contactType1.in' => 'The contactType1 field must have one of the following values: Work, Mobile,
                         Home, Office',
        'contactNumber1.required' => 'The contactNumber1 field is required.',
    );

    /**
     * @param array $people
     * @return void
     */
    public function updateValidationRules(array $people)
    {
        $this->rules['country'] = array('sometimes', 'exists:'.$this->customFieldConnection.'.country,country');

        for ($i = 0; $i < count($people); $i++) {
            $this->rules['people.'.$i.'.title'] = array(
                'required',
                'exists:'.$this->customFieldConnection.'.personTitle,personTitle',
            );
            $this->rules['people.'.$i.'.forename'] = array('required');
            $this->rules['people.'.$i.'.surname'] = array('required');
            $this->rules['people.'.$i.'.primaryContact'] = array('required', 'in:0,1');
        }
    }
}
