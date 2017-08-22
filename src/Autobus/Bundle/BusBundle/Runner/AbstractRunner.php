<?php

namespace Autobus\Bundle\BusBundle\Runner;

use Autobus\Bundle\BusBundle\Entity\Job;
use Autobus\Bundle\BusBundle\Entity\Execution;
use Autobus\Bundle\BusBundle\Event\BusServiceEvents;
use Autobus\Bundle\BusBundle\Event\BusServiceHandleEvent;
use Autobus\Bundle\BusBundle\Event\RunnerEvents;
use Autobus\Bundle\BusBundle\Event\RunnerHandleEvent;
use Autobus\Bundle\BusBundle\Event\RunnerHandleExceptionEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractRunner
 */
abstract class AbstractRunner implements RunnerInterface
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
     * @param Job         $job
     * @param Execution   $execution
     *
     * @return mixed
     */
    abstract protected function process(Request $request, Response $response, Job $job, Execution $execution);

    /**
     * @param Request   $request
     * @param Response  $response
     * @param Job       $job
     * @param Execution $execution
     *
     * @return Response
     */
    public function handle(Request $request, Response $response, Job $job, Execution $execution)
    {
        $event = new RunnerHandleEvent($this, $request, $response, $job, $execution);

        try {
            $this->eventDispatcher->dispatch(RunnerEvents::BEFORE_HANDLE, $event);

            $this->process($request, $response, $job, $execution);
            $execution->setState($execution::STATE_SUCCESS);
            $this->eventDispatcher->dispatch(RunnerEvents::SUCCESS, $event);

        } catch(\Exception $exception) {
            $this->eventDispatcher->dispatch(
                RunnerEvents::ERROR,
                new RunnerHandleExceptionEvent(
                    $this,
                    $request,
                    $response,
                    $job,
                    $execution,
                    $exception
                )
            );
        }
        $this->eventDispatcher->dispatch(RunnerEvents::AFTER_HANDLE, $event);
    }
}
