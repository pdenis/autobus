<?php

namespace Autobus\Bundle\BusExportBundle;

use Autobus\Bundle\BusExportBundle\DependencyInjection\Compiler\ConverterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AutobusBusExportBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ConverterCompilerPass());
    }
}
