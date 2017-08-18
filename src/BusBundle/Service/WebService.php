<?php


namespace BusBundle\Service;


use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebService extends AbstractBusService
{

    protected function process(Request $request, Response $response, Service $service, ServiceCall $serviceCall)
    {
        // TODO: Implement process() method.
    }
}
