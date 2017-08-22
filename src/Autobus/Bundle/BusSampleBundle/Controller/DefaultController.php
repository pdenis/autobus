<?php

namespace Autobus\Bundle\BusSampleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AutobusBusSampleBundle:Default:index.html.twig');
    }
}
