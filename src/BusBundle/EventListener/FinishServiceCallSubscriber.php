<?php

namespace BusBundle\EventListener;

use BusBundle\Event\BusServiceEvents;
use BusBundle\Event\BusServiceHandleEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class FinishServiceCallSubscriber
 */
class FinishServiceCallSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
             BusServiceEvents::AFTER_HANDLE => 'onAfterHandle'
        );
    }

    public function onAfterHandle(BusServiceHandleEvent $event)
    {
        $serviceCall = $event->getServiceCall();
        $response    = $event->getResponse();
        $service     = $event->getService();
        $request     = $event->getRequest();

        $serviceCall->finish();

        if ($response->getStatusCode() >= 400) {
            $serviceCall->setState($serviceCall::STATE_ERROR);
        }

        if ($service->getTrace()) {
            $logs = $this->logger->getLogs();
            $logs = array_map(function($log) {
                return sprintf('%s [%s] %s', $log['timestamp'], $log['priorityName'], $log['message']);
            }, $logs);
            $serviceCall->setLogs(implode("\n", $logs));

            $requestString = $request->headers->__toString();
            $requestString .= "\n\n".$request->getContent();
            $serviceCall->setRequest($requestString);

            $responseString = sprintf("HTTP %d\n\n", $response->getStatusCode());
            $responseString .= $response->headers->__toString();
            $responseString .= "\n\n".$response->getContent();
            $serviceCall->setResponse($responseString);
        }

        if ($request->getContentType() == 'xml') {
            $response->setContent('<result><![CDATA['.$response->getContent().']]></result>');
        } elseif ($request->getContentType() == 'json') {
            $response->setContent(sprintf('{"result":"%s"}', addslashes($response->getContent())));
        }
    }
}
