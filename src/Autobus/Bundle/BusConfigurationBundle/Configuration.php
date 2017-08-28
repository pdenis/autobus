<?php

namespace Autobus\Bundle\BusConfigurationBundle;

use Autobus\Bundle\BusBundle\Entity\Job;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * class Configuration 
 */
abstract class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    protected $nodeName;

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bus_job_configuration');

        return $treeBuilder;
    }

    /**
     * @param Job $job
     *
     * @return bool
     */
    public function supports(Job $job)
    {
        // TODO: Implement supports() method.
    }
}
