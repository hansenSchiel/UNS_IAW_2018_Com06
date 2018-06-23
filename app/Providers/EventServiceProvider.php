<?php

namespace ProdeIAW\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use ProdeIAW\Torneo;
use ProdeIAW\Observer\TorneoObserver;
use ProdeIAW\Fecha;
use ProdeIAW\Observer\FechaObserver;
use ProdeIAW\Grupo;
use ProdeIAW\Observer\GrupoObserver;
use ProdeIAW\Participacion;
use ProdeIAW\Observer\ParticipacionObserver;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'ProdeIAW\Events\Event' => [
            'ProdeIAW\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Torneo::observe(TorneoObserver::class);
        Fecha::observe(FechaObserver::class);
        Grupo::observe(GrupoObserver::class);
        Participacion::observe(ParticipacionObserver::class);
        parent::boot();

        //
    }
}
