<?php

namespace Autobus\Bundle\BusBundle\Command;

use Autobus\Bundle\BusBundle\Entity\Execution;
use Autobus\Bundle\BusBundle\Runner\RunnerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AutobusCronRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
          ->setName('autobus:cron:run')
          ->setDescription('Run Autobus cron jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $manager = $doctrine->getManager();
        $container = $this->getContainer();

        $jobs = $doctrine->getRepository('AutobusBusBundle:CronJob')->findDueJobs();

        foreach ($jobs as $job) {
            $execution = new Execution();

            $runnerServiceId = $job->getRunner();
            /** @var RunnerInterface $runner */
            $runner = $container->get($runnerServiceId);

            $runner->handle(new Request(), new Response(), $job, $execution);

            $job->reschedule();

            $manager->persist($execution);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
