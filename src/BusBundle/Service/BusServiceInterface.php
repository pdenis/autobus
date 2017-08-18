<?php

namespace BusBundle\Service;

use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface BusServiceInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param Service $service
     * @param ServiceCall $serviceCall
     *
     * @return Response
     */
    public function handle(Request $request, Response $response, Service $service, ServiceCall $serviceCall);
}
