<?php

namespace Jupix\Contact\Persistence;

/**
 * Class EloquentIndividualPerson
 * @package Jupix\Contact\Persistence
 */
class EloquentIndividualPerson extends \Eloquent
{
    /**
     * @var string
     */
    protected $connection = 'clientRW';

    /**
     * @var string
     */
    protected $table = 'individual_person';

    /**
     * @var string
     */
    protected $primaryKey = 'personID';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = array(
        'individualID',
        'personTitle',
        'personForename',
        'personSurname',
        'primaryContact'
    );
}
