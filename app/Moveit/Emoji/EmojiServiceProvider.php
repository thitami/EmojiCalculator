<?php

namespace Moveit\Emoji;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;
use Jupix\Contact\Persistence\EloquentCompany;
use Jupix\Contact\Persistence\EloquentCompanyPerson;
use Jupix\Contact\Persistence\EloquentContact;
use Jupix\Contact\Persistence\EloquentContactIndex;
use Jupix\Contact\Persistence\EloquentIndividual;
use Jupix\Contact\Persistence\EloquentIndividualPerson;
use Jupix\Contact\Services\ContactService;
use Jupix\Contact\Validators\CreateContactValidator;
use Jupix\Contact\Repositories\EloquentContactRepository;
use Jupix\Contact\Repositories\ContactRepository;

/**
 * Class EmojiServiceProvider
 * @package Moveit\Emoji
 */
class EmojiServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register binds a ContactService reference to the actual service.
     */
    public function register()
    {
        $this->app->bind(
            ContactService::class,
            function ($app) {
                return new ContactService(
                    $app->make(MessageBag::class),
                    $app->make(ContactRepository::class),
                    new CreateContactValidator($app->make('validator'))
                );
            }
        );

    }
}
