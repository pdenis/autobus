<?php

namespace Autobus\Bundle\BusConfigurationBundle\Controller;

use Autobus\Bundle\BusConfigurationBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConfigurationController extends Controller
{
    /**
     * @param Request $request
     * @param string  $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $job = $this->getDoctrine()->getManager()->getRepository('AutobusBusBundle:Job')->find($id);

        if (!$job) {
            throw new NotFoundHttpException(sprintf('job %s not found', $id));
        }

        $config = $this->get('bus_configuration.processor.configuration')->process(new Configuration(), $job);

        die(print_r($config));
        return $this->render('AutobusBusConfigurationBundle:Configuration:edit.html.twig');
    }
}
