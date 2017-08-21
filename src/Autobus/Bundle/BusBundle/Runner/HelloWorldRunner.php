<?php

namespace Autobus\Bundle\BusBundle\Runner;

use Autobus\Bundle\BusBundle\Entity\Job;
use Autobus\Bundle\BusBundle\Entity\Execution;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloWorldRunner extends AbstractRunner
{
    public function process(Request $request, Response $response, Job $job, Execution $execution)
    {
        return $response->setContent('Hello world!');
    }
}
