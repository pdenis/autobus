<?php

namespace Autobus\Bundle\BusSampleBundle\DataFixtures\ORM;

use Autobus\Bundle\BusBundle\Entity\WebJob;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSampleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $job = new WebJob();
        $job->setName('Hello world');
        $job->setRunner('bus_sample.runner.helloworld');
        $job->setPath('hello-world');
        $job->setSecure(false);
        $job->setTrace(true);
        $job->setMethods(['GET']);

        $manager->persist($job);
        $manager->flush();
    }
}
