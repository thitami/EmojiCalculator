<?php

namespace Moveit\Emoji;

use Config;


/**
 * Class EmojiService
 * @package Moveit\Emoji
 */
class EmojiService
{
    /**
     * @var ContactRepository
     */
    protected $contactRepository;

    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @var CreateContactValidator
     */
    protected $validator;

    /**
     * ContactService constructor.
     *
     * @param MessageBag $errors
     * @param ContactRepository $contactRepository
     * @param CreateContactValidator $createContactValidator
     */
    public function __construct(
        MessageBag $errors,
        ContactRepository $contactRepository,
        CreateContactValidator $createContactValidator
    ) {
        $this->errors = $errors;
        $this->contactRepository = $contactRepository;
        $this->validator = $createContactValidator;
    }

    /**
     * @param array $input
     *
     * @return int|bool
     */
    public function save(array $input)
    {
        $this->validator->updateValidationRules($input['people']);

        if (!$this->valid($input)) {
            $this->errors->add('ContactService@save', 'Contact(s) have not been created.');
            $this->errors->merge($this->validator->errors()->all());

            return false;
        }

        $currentDate = date('Y-m-d H:i:s');
        $input['recordCreatedBy'] = Config::get('request.applicationID') ?: ExternalApplication::NONE;
        $input['recordUpdatedBy'] = Config::get('request.applicationID') ?: ExternalApplication::NONE;
        $input['dateCreated'] = $currentDate;
        $input['dateUpdated'] = $currentDate;

        $contactID = $this->contactRepository->createIndividualContact($input);

        if (!$contactID) {
            $this->errors->add('ContactService@save', 'Invalid Contact has not been creacted successfully.');

            return false;
        }

        return $contactID;
    }

    /**
     * @return MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @param array $input
     *
     * @return mixed
     * @throws \Exception
     */
    private function valid(array $input)
    {
        if (isset($this->validator)) {
            return $this->validator->with($input)->passes();
        }

        throw new \Exception('The validator is not set!');
    }

}
