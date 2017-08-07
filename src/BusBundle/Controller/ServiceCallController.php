<?php

namespace BusBundle\Controller;

use BusBundle\Entity\ServiceCall;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Service call controller.
 */
class ServiceCallController extends Controller
{
    /**
     * Finds and displays a service call entity.
     *
     * @param ServiceCall $serviceCall
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(ServiceCall $serviceCall)
    {
        return $this->render(
          'BusBundle::service_call/show.html.twig',
          array(
            'service_call' => $serviceCall,
          )
        );
    }
}
