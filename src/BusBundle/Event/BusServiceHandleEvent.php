<?php

namespace BusBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;

/**
 * Class BusServiceHandleEvent
 */
class BusServiceHandleEvent extends Event
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var ServiceCall
     */
    protected $serviceCall;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Service     $service
     * @param ServiceCall $serviceCall
     */
    public function __construct(Request $request, Response $response, Service $service, ServiceCall $serviceCall)
    {
        $this->service = $service;
        $this->serviceCall = $serviceCall;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return ServiceCall
     */
    public function getServiceCall()
    {
        return $this->serviceCall;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
