<?php

namespace BusBundle;

use BusBundle\DependencyInjection\Compiler\BusServicePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BusBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new BusServicePass());
    }
}
