<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ExampleEvent' => [
            'App\Listeners\ExampleListener',
        ],
        'App\Events\TransactionEvent' => [
            'App\Listeners\TransactionListener',
        ],
        'App\Events\TransactionProcessEvent' => [
            'App\Listeners\TransactionProcessListener'
        ],
        'App\Events\TransactionProcessedEvent' => [
            'App\Listeners\TransactionProcessedListener'
        ]
    ];

    /**
     * Register any event for your appication
     * 
     * @return avoid
     */
    public function boot()
    {
        parent::boot();
    }
}
