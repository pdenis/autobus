<?php

namespace Autobus\Bundle\BusConfigurationBundle\Processor;

use Autobus\Bundle\BusBundle\Entity\Job;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

/**
 * class ConfigurationProcessor 
 */
class ConfigurationProcessor 
{
    /**
     * @var Processor
     */
    protected $processor;

    /**
     * @param Processor $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * @param ConfigurationInterface $configuration
     * @param Job                    $job
     *
     * @return array
     */
    public function process(ConfigurationInterface $configuration, Job $job)
    {
        return $this->processor->processConfiguration($configuration, $job->getConfigArray());
    }
}
