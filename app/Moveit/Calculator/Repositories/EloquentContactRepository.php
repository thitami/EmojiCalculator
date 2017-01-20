<?php namespace Jupix\Contact\Repositories;

use Entities\userDatabase\Prospect;
use DB;
use Illuminate\Support\Facades\Config;
use Jupix\Contact\Persistence\EloquentCompany;
use Jupix\Contact\Persistence\EloquentCompanyPerson;
use Jupix\Contact\Persistence\EloquentContact;
use Jupix\Contact\Persistence\EloquentContactIndex;
use Jupix\Contact\Persistence\EloquentIndividual;
use Jupix\Contact\Persistence\EloquentIndividualPerson;
use Jupix\Models\PrimaryPartyType;

/**
 * Class EloquentContactRepository
 * @package Jupix\Contact\Repositories
 */
class EloquentContactRepository implements ContactRepository
{
    /**
     * @var EloquentContact
     */
    protected $eloquentContact;

    /**
     * @var EloquentCompany
     */
    protected $eloquentCompany;

    /**
     * @var EloquentCompanyPerson
     */
    protected $eloquentCompanyPerson;

    /**
     * @var EloquentIndividual
     */
    protected $eloquentIndividual;

    /**
     * @var EloquentIndividualPerson
     */
    protected $eloquentIndividualPerson;

    /**
     * @var EloquentContactIndex
     */
    protected $eloquentContactIndex;

    /**
     * EloquentContactRepository constructor.
     *
     * @param EloquentContact $eloquentContact
     * @param EloquentCompany $eloquentCompany
     * @param EloquentCompanyPerson $eloquentCompanyPerson
     * @param EloquentIndividual $eloquentIndividual
     * @param EloquentIndividualPerson $eloquentIndividualPerson
     * @param EloquentContactIndex $eloquentContactIndex
     */
    public function __construct(
        EloquentContact $eloquentContact,
        EloquentCompany $eloquentCompany,
        EloquentCompanyPerson $eloquentCompanyPerson,
        EloquentIndividual $eloquentIndividual,
        EloquentIndividualPerson $eloquentIndividualPerson,
        EloquentContactIndex $eloquentContactIndex
    ) {

        $this->eloquentContact = $eloquentContact;
        $this->eloquentCompany = $eloquentCompany;
        $this->eloquentCompanyPerson = $eloquentCompanyPerson;
        $this->eloquentIndividual = $eloquentIndividual;
        $this->eloquentIndividualPerson = $eloquentIndividualPerson;
        $this->eloquentContactIndex = $eloquentContactIndex;
    }

    /**
     * Creates a contact
     * @param array $data - Data to create the contact
     * @return int - The new contactID
     */
    public function create($data)
    {
        $newContact = $this->eloquentContact->create($data);

        return $newContact->contactID;
    }

    /**
     * Creates a company contact and returns their contactID
     * @param array $data - The relevant data to create a company contact
     * @return int - The new contactID
     */
    public function createCompanyContact($data)
    {
        $contactID = 0;
        $indexNames[] = strtolower($data['companyName'].' '.$data['companyBranchName']);
        $companyID = $this->createCompany($data);
        //echo "<br>New company: ".$companyID."<br>";

        // - - - ADD COMPANY PERSONS - - - //
        if (isset($data['people'])) {
            foreach ($data['people'] as $person) {
                $companyPersonID = $this->createCompanyPerson($companyID, $person);
                //echo "<br>New company person: ".$companyPersonID."<br>";

                $indexNames[] = $person['forename'].' '.$person['surname'];
                $indexNames[] = $person['surname'];
                // - - - UPDATE ADDRESSEE DEAR - - - //
                if ($person['primaryContact'] == 1) {
                    $addressee = $person['title'].' '.$person['forename'].' '.$person['surname'];
                    $dear = $person['title'].' '.$person['surname'];

                    $updateCompany = $this->eloquentCompany->find($companyID);
                    $updateCompany->addressee = $addressee;
                    $updateCompany->dear = $dear;
                    $updateCompany->save();
                }
            }
        } else {
            //echo "<br>no person specified<br>";
            // - - - create dummy person - - - //
            $person = array(
                'personTitle' => '',
                'personForename' => '',
                'personSurname' => '',
                'primaryContact' => 1,
            );
            $companyPersonID = $this->createCompanyPerson($companyID, $person);
            //echo "<br>New empty company person: ".$companyPersonID."<br>";
        }

        // - - - ADD CONTACT (company) - - - //
        $cvNameAnchor = $this->getCompanyContactViewNameAnchor($companyID);
        //echo "<br>Contact view name: ".$cvNameAnchor['contactViewName']."<br>";
        //echo "<br>Contact view anchor: ".$cvNameAnchor['contactViewAnchor']."<br>";

        //insert new contact
        $newContact = array(
            'primaryPartyID' => $companyID,
            'primaryPartyType' => $data['primaryPartyType'],
            'contactViewName' => $cvNameAnchor['contactViewName'],
            'contactViewAnchor' => $cvNameAnchor['contactViewAnchor'],
            'validEmail' => $data['validEmail'],
            'recordCreatedBy' => $data['recordCreatedBy'],
            'recordUpdatedBy' => $data['recordUpdatedBy'],
            'dateLastContacted' => $data['dateLastContacted'],
            'dateCreated' => $data['dateCreated'],
            'dateUpdated' => $data['dateUpdated'],
        );
        $contactID = $this->create($newContact);
        //echo "<br>New contact: ".$contactID."<br>";

        // - - - ADD INDICES - - - //
        $indexNames = array_unique($indexNames);
        foreach ($indexNames as $index) {
            $this->createContactIndex(array('contactID' => $contactID, 'contactName' => $index));
        }

        //echo "<br>Indices: "; print_r($indexNames); echo "<br>";

        return $contactID;
    }


    /**
     * Creates a company Person
     * @param int $companyID - The related company
     * @param array $person - Data to create the person
     * @return int
     */
    private function createCompanyPerson($companyID, $person)
    {
        //This is not a precedent!
        //Mapping has been done to keep the API consistent across all areas
        $values = array(
            'companyID' => $companyID,
            'personTitle' => $person['title'],
            'personForename' => $person['forename'],
            'personSurname' => $person['surname'],
            'primaryContact' => $person['primaryContact'],
        );
        $newCompanyPerson = $this->eloquentCompanyPerson;
        $newCompanyPerson = $newCompanyPerson->create($values);

        return $newCompanyPerson->personID;
    }

    /**
     * Creates an Individual contact and returns their contactID
     *
     * @param array $data - The relevant data to create an Individual
     *
     * @return int - The new individualId
     */
    public function createIndividualContact($data)
    {
        // Simple check to enforce at least one person required
        if (!isset($data['people'])) {
            return false;
        }
        //Remove all whitespace
        $data['contactNumber1'] = preg_replace('/\s+/', '', $data['contactNumber1']);
        $individualID = $this->createIndividual($data);
        $indexNames = array();
        // - - - ADD COMPANY PERSONS - - - //
        foreach ($data['people'] as $person) {

            $individualPersonID = $this->createIndividualPerson($individualID, $person);

            $indexNames[] = $person['forename'].' '.$person['surname'];
            $indexNames[] = $person['surname'];

            // - - - UPDATE ADDRESSEE DEAR - - - //
            if ($person['primaryContact'] == 1) {

                $addressee = $person['title'].' '.$person['forename'].' '.$person['surname'];
                $dear = $person['title'].' '.$person['surname'];
                $updateIndividual = $this->eloquentIndividual->find($individualID);
                $updateIndividual->addressee = $addressee;
                $updateIndividual->dear = $dear;
                $updateIndividual->save();

            }
        }

        // - - - ADD CONTACT (company) - - - //
        $cvNameAnchor = $this->getIndividualContactViewNameAnchor($data['people']);

        //insert new contact
        $newContact = array(
            'primaryPartyID' => $individualID,
            'primaryPartyType' => PrimaryPartyType::INDIVIDUAL,
            'contactViewName' => $cvNameAnchor['contactViewName'] ?: '',
            'contactViewAnchor' => $cvNameAnchor['contactViewAnchor'] ?: '',
            'emailAddress' => $data['emailAddress'],
            'recordCreatedBy' => $data['recordCreatedBy'],
            'recordUpdatedBy' => $data['recordUpdatedBy'],
            'dateCreated' => $data['dateCreated'],
            'dateUpdated' => $data['dateUpdated'],
        );

        $contactID = $this->create($newContact);
        // - - - ADD INDICES - - - //
        foreach ($indexNames as $index) {
            $this->createContactIndex(array('contactID' => $contactID, 'contactName' => $index));
        }

        return $contactID;
    }

    /**
     * Creates a new Individual
     *
     * @param array $data
     * @return int $individualID
     */
    public function createIndividual($data)
    {
        $newIndividual = $this->eloquentIndividual->create($data);

        return $newIndividual->individualID;
    }

    /**
     * Creates a new IndividualPerson
     *
     * @param int $individualID
     * @param array $person
     */
    private function createIndividualPerson($individualID, $person)
    {
        $values = array(
            'individualID' => $individualID,
            'personTitle' => $person['title'],
            'personForename' => $person['forename'],
            'personSurname' => $person['surname'],
            'primaryContact' => $person['primaryContact'],
        );

        $newIndividualPerson = $this->eloquentIndividualPerson->create($values);

        return $newIndividualPerson->personID;
    }

    /**
     * Gets the contactViewName and contactViewAnchor values of
     * an IndividualContact
     *
     * @param array $people
     * @return array $data
     */
    private function getIndividualContactViewNameAnchor(array $people)
    {
        $contactViewAnchorDisplayName = '';
        $contactViewDisplayAnchor = '';
        foreach ($people as $person) {
            if ($contactViewAnchorDisplayName != '') {
                $contactViewAnchorDisplayName .= ', ';
                $contactViewDisplayAnchor .= ', ';
            }
            $contactViewAnchorDisplayName .= $person['title'].' '.$person['forename'].' '.$person['surname'];
            $contactViewDisplayAnchor .= $person['surname'].' '.$person['forename'].' '.$person['title'];
        }

        return array(
            'contactViewName' => $contactViewAnchorDisplayName,
            'contactViewAnchor' => $contactViewDisplayAnchor
        );
    }

    /**
     * Creates a contact index
     *
     * @param array $data - Data to create the index
     * @return void
     */
    public function createContactIndex($data)
    {
        $contactIndex = new EloquentContactIndex();

        $contactIndex->create($data);
    }

    /**
     * Returns company contact view name and anchor
     * @param int $companyID - Related company
     * @return array
     */
    private function getCompanyContactViewNameAnchor($companyID)
    {
        $data = array('contactViewName' => '', 'contactViewAnchor' => '');
        //select contact view name
        $cvName = EloquentCompany::select(
            DB::raw(
                "CONCAT(group_concat(`company_person`.`personTitle`,_latin1' ',
				`company_person`.`personForename`,_latin1' ',`company_person`.`personSurname` order by `company_person`.`primaryContact` DESC separator ', '),' (',
				if((`company`.`companyBranchName` <> _latin1''),concat(`company`.`companyName`,_latin1' - ',`company`.`companyBranchName`),`company`.`companyName`),')') AS contactViewName"
            )
        )
            ->join('company_person', 'company_person.companyID', '=', 'company.companyID')
            ->where('company.companyID', '=', $companyID)
            ->groupBy('company.companyID')
            ->first();
        $data['contactViewName'] = $cvName->contactViewName;

        //select contact view anchor
        $cvAnchor = EloquentCompany::select(
            DB::raw(
                "if((
				`company`.`companyBranchName` <> _latin1''),concat(
				`company`.`companyName`,_latin1' - ',
				`company`.`companyBranchName`),
				`company`.`companyName`) AS contactViewAnchor"
            )
        )
            ->join('company_person', 'company_person.companyID', '=', 'company.companyID')
            ->where('company.companyID', '=', $companyID)
            ->groupBy('company.companyID')
            ->first();
        $data['contactViewAnchor'] = $cvAnchor->contactViewAnchor;

        return $data;
    }

    /**
     * Creates a company
     * @param array $data - Data to create a company
     * @return int - The new companyID
     */
    private function createCompany($data)
    {
        $newCompany = $this->eloquentCompany->create($data);

        return $newCompany->companyID;
    }

    /**
     * Gets data object for a given contact
     * @param array $contactID - The contact
     * @return object - The data object of the existing contact
     */
    public function getContact($contactID)
    {
        return $this->eloquentContact->find($contactID);
    }

    /**
     * Returns the solicitor (solicitor's contactID) for a given contact
     * @param int $contactID - The contact to get the solicitor of
     * @return int - The solicitor's contactID
     */
    public function getSolicitor($contactID)
    {
        $contact = $this->eloquentContact->find($contactID);

        return $contact->solicitorID;
    }

    /**
     * Set the solicictor for a contact
     * @param int $contactID - The contact to set the solicitor for
     * @param int $solicitorID - The solicitor's contactID
     * @return boolean
     */
    public function setSolicitor($contactID, $solicitorID)
    {
        $contact = $this->eloquentContact->find($contactID);

        //only update if values are different
        if ($contact->solicitorID != $solicitorID) {
            $contact->solicitorID = $solicitorID;

            return $contact->save();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactSummary($contactID)
    {
        if (!$contact = $this->eloquentContact->find($contactID)) {
            return false;
        }

        switch (strtoupper($contact->primaryPartyType)) {
            case 'I':
                $contactSummary = $this->getIndividualSummary($contact->primaryPartyID);
                break;

            case 'C':
                $contactSummary = $this->getCompanySummary($contact->primaryPartyID);
                break;

            case 'P':
                $contactSummary = $this->getProspectSummary($contact->primaryPartyID);
                break;

            default:
                return false;
        }

        return $contactSummary;
    }

    /**
     * Returns individual contact's summary data
     *
     * @param int $individualID - The individualID
     * @return Illuminate\Database\Eloquent\Model
     */
    private function getIndividualSummary($individualID)
    {
        $individual = new EloquentIndividual();
        $fields = array(
            'addressee as contactName',
            'emailAddress as contactEmail',
            'contactNumber1 as contactNumber',
            'addressPostcode as contactPostcode',
        );

        return $individual->find($individualID, $fields);
    }

    /**
     * Returns company contact's summary data
     *
     * @param int $companyID - The companyID
     * @return Illuminate\Database\Eloquent\Model
     */
    private function getCompanySummary($companyID)
    {
        $fields = array(
            'addressee as contactName',
            'emailAddress as contactEmail',
            'contactNumber1 as contactNumber',
            'addressPostcode as contactPostcode',
        );

        return $this->eloquentCompany->find($companyID, $fields);
    }

    /**
     * Returns prospect contact's summary data
     *
     * @param int $prospectID - The prospectID
     * @return Illuminate\Database\Eloquent\Model
     */
    private function getProspectSummary($prospectID)
    {
        $prospect = new Prospect();
        $fields = array(
            'prospectName as contactName',
            'emailAddress as contactEmail',
            'contactNumber1 as contactNumber',
            'addressPostcode as contactPostcode',
        );

        return $prospect->find($prospectID, $fields);
    }

}
