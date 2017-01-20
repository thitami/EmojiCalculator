<?php namespace Jupix\Contact\Repositories;

/**
 * Interface ContactRepository
 * @package Jupix\Contact\Repositories
 */
interface ContactRepository
{
    /**
     * Creates a contact
     * @param array $data - Data to create the contact
     * @return int - The new contactID
     */
    public function create($data);

    /**
     * Creates a company contact and returns their contactID
     * @param array $data - The relevant data to create a company contact
     * @return int - The new contactID
     */
    public function createCompanyContact($data);

    /**
     * @return array $data
     */
    public function createContactIndex($data);

    /**
     * Gets data object for a given contact
     * @param array $contactID - The contact
     * @return object - The data object of the existing contact
     */
    public function getContact($contactID);

    /**
     * Creates a new Individual object and stores it into the DB
     *
     * @param array $data
     * @return int|bool
     */
    public function createIndividual($data);

    /**
     * Mainly, creates a new Contact object and stores it into the DB
     * Also, creates new objects of:
     *  - Individual
     *  - IndividualPerson
     *  - ContactIndex
     *
     * and subsequently stores them into the respective DB table.
     *
     * @param array $data
     * @return int|bool
     */
    public function createIndividualContact($data);

    /**
     * Returns the solicitor (solicitor's contactID) for a given contact
     * @param int $contactID - The contact to get the solicitor of
     * @return int - The solicitor's contactID
     */
    public function getSolicitor($contactID);

    /**
     * Set the solicictor for a contact
     * @param int $contactID - The contact to set the solicitor for
     * @param int $solicitorID - The solicitor's contactID
     * @return boolean
     */
    public function setSolicitor($contactID, $solicitorID);

    /**
     * Returns a contact's summary data
     *
     * @param int $contactID
     *
     * @return mixed
     */
    public function getContactSummary($contactID);
}
