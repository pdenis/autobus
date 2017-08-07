<?php

namespace BusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use BusBundle\Service\ServiceChain;

class BusServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ServiceChain::class)) {
            return;
        }

        $definition = $container->findDefinition(ServiceChain::class);

        $taggedServices = $container->findTaggedServiceIds('bus.service');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addService', array(new Reference($id), $id));
        }
    }
}
