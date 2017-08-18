<?php

namespace BusBundle\Service;

use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use BusBundle\Event\BusServiceEvents;
use BusBundle\Event\BusServiceHandleEvent;
use BusBundle\Event\BusServiceHandleExceptionEvent;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractBusService implements BusServiceInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Service     $service
     * @param ServiceCall $serviceCall
     *
     * @return mixed
     */
    abstract protected function process(Request $request, Response $response, Service $service, ServiceCall $serviceCall);

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Service     $service
     * @param ServiceCall $serviceCall
     */
    public function handle(Request $request, Response $response, Service $service, ServiceCall $serviceCall)
    {
        $event = new BusServiceHandleEvent($request, $response, $service, $serviceCall);

        try {
            $this->eventDispatcher->dispatch(BusServiceEvents::BEFORE_HANDLE, $event);

            $this->process($request, $response, $service, $serviceCall);
            $serviceCall->setState($serviceCall::STATE_SUCCESS);
            $this->eventDispatcher->dispatch(BusServiceEvents::SUCCESS, $event);
        } catch(\Exception $exception) {
            $this->eventDispatcher->dispatch(
                BusServiceEvents::ERROR,
                new BusServiceHandleExceptionEvent(
                    $request,
                    $response,
                    $service,
                    $serviceCall,
                    $exception
                )
            );
        }
        $this->eventDispatcher->dispatch(BusServiceEvents::AFTER_HANDLE, $event);
    }

    /**
     * @param Request $request
     * @param Service $service
     * @param ServiceCall $serviceCall
     */
    public function beforeHandle(Request $request, Service $service, ServiceCall $serviceCall)
    {

    }
}
