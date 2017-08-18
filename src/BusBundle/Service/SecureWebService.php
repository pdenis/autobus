<?php

namespace BusBundle\Service;

use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

abstract class SecureWebService extends AbstractBusService
{

}
