<?php

namespace Autobus\Bundle\BusExportBundle\DependencyInjection\Compiler;

use Autobus\Bundle\BusExportBundle\Converter\ConverterChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * class ConverterCompilerPass
 */
class ConverterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ConverterChain::class)) {
            return;
        }

        $definition = $container->findDefinition(ConverterChain::class);

        $taggedServices = $container->findTaggedServiceIds('bus_export.converter');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addConverter', array(new Reference($id), $id));
        }
    }
}
