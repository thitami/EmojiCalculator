<?php

namespace Jupix\Contact\Persistence;

/**
 * Class EloquentIndividual
 * @package Jupix\Contact\Persistence
 */
class EloquentIndividual extends \Eloquent
{
    /**
     * @var string
     */
    protected $connection = 'clientRW';

    /**
     * @var string
     */
    protected $table      = 'individual';

    /**
     * @var string
     */
    protected $primaryKey = 'individualID';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = array(
        'addressee',
        'dear',
        'addressName',
        'addressNumber',
        'addressStreet',
        'address2',
        'address3',
        'address4',
        'addressPostcode',
        'country',
        'contactType1',
        'contactType2',
        'contactType3',
        'contactNumber1',
        'contactNumber2',
        'contactNumber3',
        'emailAddress'
    );
}
