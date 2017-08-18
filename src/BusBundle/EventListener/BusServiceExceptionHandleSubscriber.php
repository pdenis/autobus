<?php

namespace BusBundle\EventListener;

use BusBundle\Event\BusServiceEvents;
use BusBundle\Event\BusServiceHandleExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class BusServiceExceptionHandleSubscriber
 */
class BusServiceExceptionHandleSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            BusServiceEvents::ERROR => 'onHandleException'
        );
    }

    public function onHandleException(BusServiceHandleExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = $event->getResponse();

        $response->setContent($exception->getMessage());
        if ($exception instanceof BadRequestHttpException) {
            $response->setStatusCode(400);
        } elseif ($exception instanceof AuthenticationException) {
            $response->setStatusCode(401);
        } else {
            $response->setStatusCode(500);
        }
    }
}
