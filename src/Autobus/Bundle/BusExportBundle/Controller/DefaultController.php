<?php

namespace Autobus\Bundle\BusExportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AutobusBusExportBundle:Default:index.html.twig');
    }
}
