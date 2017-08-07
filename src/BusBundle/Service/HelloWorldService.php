<?php

namespace BusBundle\Service;

use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloWorldService extends AbstractBusService
{

    public function handle(Request $request, Response $response, Service $service, ServiceCall $serviceCall)
    {
        return $response->setContent('Hello world!');
    }
}
