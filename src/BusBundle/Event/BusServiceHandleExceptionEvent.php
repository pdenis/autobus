<?php

namespace BusBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;

/**
 * Class BusServiceHandleExceptionEvent
 */
class BusServiceHandleExceptionEvent extends BusServiceHandleEvent
{
    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Service     $service
     * @param ServiceCall $serviceCall
     */
    public function __construct(Request $request, Response $response, Service $service, ServiceCall $serviceCall, \Exception $exception)
    {
        parent::__construct($request, $response, $service, $serviceCall);

        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
