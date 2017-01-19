<?php

namespace Jupix\Contact\Persistence;

/**
 * Class EloquentIndividual
 * @package Jupix\Contact\Persistence
 */
class EloquentContactIndex extends \Eloquent
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
    protected $table = 'contact_index';

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = array(
        'contactName',
        'contactID'
    );
}
