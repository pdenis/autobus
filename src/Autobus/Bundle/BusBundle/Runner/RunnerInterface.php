<?php

namespace Autobus\Bundle\BusBundle\Runner;

use Autobus\Bundle\BusBundle\Entity\Job;
use Autobus\Bundle\BusBundle\Entity\Execution;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface RunnerInterface
{
    /**
     * @param Request   $request
     * @param Response  $response
     * @param Job       $job
     * @param Execution $execution
     *
     * @return Response
     */
    public function handle(Request $request, Response $response, Job $job, Execution $execution);
}
