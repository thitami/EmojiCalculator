<?php namespace Jupix\Contact\Persistence;

/**
 * Class EloquentCompanyPerson
 * @package Jupix\Contact\Persistence
 */
class EloquentCompanyPerson extends \Eloquent
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
    protected $table = 'company_person';

    /**
     * @var string
     */
    protected $primaryKey = 'personID';

    /**
     * @var array
     */
    protected $fillable = array(
        'companyID',
        'personTitle',
        'personForename',
        'personSurname',
        'primaryContact',
    );
}
