<?php

namespace App\Listeners;

use App\Events\MyEvent;
use Illuminate\Support\Facades\Log;
use Picpay\Otel\Metrics\Counter;

class MyListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info('Teste');

        Counter::add(1, 'metric_name', [
            'label1'=>'value1',
            'label2'=>'value2'
        ], 'description');
    }

    /**
     * Handle the event.
     *
     * @param MyEvent $event
     * @return void
     */
    public function handle(MyEvent $event)
    {
        //
    }
}
