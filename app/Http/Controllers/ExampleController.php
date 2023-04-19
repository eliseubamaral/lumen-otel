<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use Illuminate\Support\Facades\Event;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * @throws MetricsRegistrationException
     */
    public function __invoke()
    {
        Event::dispatch(new MyEvent());
    }
}
