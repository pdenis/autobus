<?php


namespace BusBundle\Service;

class ServiceChain
{
    /**
     * @var BusServiceInterface[]
     */
    private $services;

    public function __construct()
    {
        $this->services = array();
    }

    public function addService(BusServiceInterface $service, $id)
    {
        $this->services[$id] = $service;
    }

    /**
     * @return BusServiceInterface[]
     */
    public function getServices()
    {
        return $this->services;
    }
}
