<?php namespace Jupix\Contact\Persistence;

/**
 * Class EloquentCompany
 * @package Jupix\Contact\Persistence
 */
class EloquentCompany extends \Eloquent
{
    /**
     * @var string
     */
    protected $connection = 'clientRW';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'company';

    /**
     * @var string
     */
    protected $primaryKey = 'companyID';

    /**
     * @var array
     */
    protected $fillable = array(
        'companyName',
        'companyBranchName',
        'addressName',
        'addressNumber',
        'addressStreet',
        'address2',
        'address3',
        'address4',
        'addressPostcode',
        'country',
        'contactType1',
        'contactNumber1',
        'contactType2',
        'contactNumber2',
        'contactType3',
        'contactNumber3',
        'emailAddress',
        'websiteAddress',
        'contactNotes',
    );
}
