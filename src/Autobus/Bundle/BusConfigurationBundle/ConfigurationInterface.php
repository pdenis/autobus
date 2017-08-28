<?php


namespace Autobus\Bundle\BusConfigurationBundle;

use Autobus\Bundle\BusBundle\Entity\Job;

use Symfony\Component\Config\Definition\ConfigurationInterface as BaseConfigurationInterface;

/**
 * class ConfigurationInterface 
 */
interface ConfigurationInterface extends BaseConfigurationInterface
{
    /**
     * @param Job $job
     *
     * @return bool
     */
    public function supports(Job $job);

    /**
     * @return string
     */
    public function getParentNodeName();
}
