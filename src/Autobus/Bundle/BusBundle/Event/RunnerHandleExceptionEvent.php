<?php

namespace Autobus\Bundle\BusBundle\Event;

use Autobus\Bundle\BusBundle\Runner\RunnerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Autobus\Bundle\BusBundle\Entity\Job;
use Autobus\Bundle\BusBundle\Entity\Execution;

/**
 * Class RunnerHandleExceptionEvent
 */
class RunnerHandleExceptionEvent extends RunnerHandleEvent
{
    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @param RunnerInterface $runner
     * @param Request         $request
     * @param Response        $response
     * @param Job             $job
     * @param Execution       $execution
     * @param \Exception      $exception
     */
    public function __construct(RunnerInterface $runner, Request $request, Response $response, Job $job, Execution $execution, \Exception $exception)
    {
        parent::__construct($runner, $request, $response, $job, $execution);

        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
