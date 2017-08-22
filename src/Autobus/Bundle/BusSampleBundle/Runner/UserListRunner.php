<?php

namespace Autobus\Bundle\BusSampleBundle\Runner;

use Autobus\Bundle\BusBundle\Entity\Execution;
use Autobus\Bundle\BusBundle\Entity\Job;
use Autobus\Bundle\BusBundle\Runner\AbstractRunner;
use Autobus\Bundle\BusExportBundle\Runner\ExportRunnerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * class UserListRunner 
 */
class UserListRunner extends AbstractRunner implements ExportRunnerInterface
{
    private $users = array();

    private $request;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->users;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->request->headers->has('Accept') ? $this->request->headers->get('Accept') : 'application/json';
    }

    /**
     * @param Request   $request
     * @param Response  $response
     * @param Job       $job
     * @param Execution $execution
     *
     * @return mixed
     */
    protected function process(Request $request, Response $response, Job $job, Execution $execution)
    {
        $this->request = $request;
        $this->users = array(
            array(
                'id' => 1,
                'username' => 'john.doe'
            ),
            array(
                'id' => 2,
                'username' => 'jack.dae'

            )
        );
    }
}
