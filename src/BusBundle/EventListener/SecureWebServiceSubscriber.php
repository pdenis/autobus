<?php

namespace BusBundle\EventListener;

use BusBundle\Entity\WebService;
use BusBundle\Event\BusServiceEvents;
use BusBundle\Event\BusServiceHandleEvent;
use BusBundle\Security\SecurityChain;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SecureWebServiceSubscriber
 */
class SecureWebServiceSubscriber implements EventSubscriberInterface
{
    /**
     * @var SecurityChain
     */
    private $securityChain;

    public function __construct(SecurityChain $securityChain)
    {
        $this->securityChain = $securityChain;
    }

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
            BusServiceEvents::BEFORE_HANDLE => array('onBeforeHandle', 64)
        );
    }

    public function onBeforeHandle(BusServiceHandleEvent $event)
    {
        $service = $event->getService();
        $request = $event->getRequest();

        $config = $service->getConfigArray();

        if ($service instanceof WebService && $service->isSecure() && isset($config['security']['modes'])) {
            $this->securityChain->check($request, $config['security']['modes']);
        }
    }
}
