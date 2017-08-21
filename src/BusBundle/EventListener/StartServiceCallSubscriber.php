<?php

namespace BusBundle\EventListener;

use BusBundle\Event\BusServiceEvents;
use BusBundle\Event\BusServiceHandleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class StartServiceCallSubscriber
 */
class StartServiceCallSubscriber implements EventSubscriberInterface
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
            BusServiceEvents::BEFORE_HANDLE => array('onBeforeHandle', 128)
        );
    }

    /**
     * @param BusServiceHandleEvent $event
     */
    public function onBeforeHandle(BusServiceHandleEvent $event)
    {
        $serviceCall = $event->getServiceCall();
        $request = $event->getRequest();
        $service = $event->getService();

        $serviceCall
            ->setDate(new \DateTime())
            ->setCaller($event->getRequest()->getClientIp())
            ->setService($service)
            ->start();

        $allowedMethods = $service->getMethods();
        if (!empty($allowedMethods) && !in_array($request->getMethod(), $allowedMethods)) {
            throw new BadRequestHttpException(sprintf('Method [%s] not allowed (allowed methods: %s]', $request->getMethod(), implode(', ', $allowedMethods)));
        }
    }
}
