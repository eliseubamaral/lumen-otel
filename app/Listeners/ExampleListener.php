<?php

namespace App\Listeners;

use App\Events\MyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OpenTelemetry\API\Metrics\MeterProviderInterface;
use OpenTelemetry\SDK\Metrics\MetricReaderInterface;

class ExampleListener
{
    public function __construct(MeterProviderInterface $meterProvider, private MetricReaderInterface $metricReader)
    {
        // substitua .microservico.contexto para .<nome_do_seu_microservico>.<funcionalidade>
        $meter = $meterProvider->getMeter('otel.picpay.microservico.contexto');

        $this->metricTeste = $meter->createCounter(
            'Teste', null, 'Description Metrica de teste'
        );
    }

    public function handle(MyEvent $event)
    {
        $this->metricTeste->add(1, [
            'label' => uniqid(),
        ]);

        $this->metricReader->collect();
    }
}
