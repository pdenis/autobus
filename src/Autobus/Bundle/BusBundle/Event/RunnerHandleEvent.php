<?php

namespace Autobus\Bundle\BusBundle\Event;

use Autobus\Bundle\BusBundle\Entity\Job;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Autobus\Bundle\BusBundle\Entity\Execution;

/**
 * Class RunnerHandleEvent
 */
class RunnerHandleEvent extends Event
{
    /**
     * @var Job
     */
    protected $job;

    /**
     * @var Execution
     */
    protected $execution;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Job         $job
     * @param Execution   $execution
     */
    public function __construct(Request $request, Response $response, Job $job, Execution $execution)
    {
        $this->job       = $job;
        $this->execution = $execution;
        $this->request   = $request;
        $this->response  = $response;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @return Execution
     */
    public function getExecution()
    {
        return $this->execution;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
