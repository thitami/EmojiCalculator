<?php namespace Jupix\Contact\Persistence;

/**
 * Class EloquentContact
 * @package Jupix\Contact\Persistence
 */
class EloquentContact extends \Eloquent
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
    protected $table = 'contact';

    /**
     * @var string
     */
    protected $primaryKey = 'contactID';

    /**
     * @var array
     */
    protected $fillable = array(
        'primaryPartyID',
        'primaryPartyType',
        'contactViewName',
        'contactViewAnchor',
        'validEmail',
        'dateLastContacted',
        'dateCreated',
        'recordCreatedBy',
        'dateUpdated',
        'recordUpdatedBy',
    );
}
