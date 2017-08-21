<?php

namespace Autobus\Bundle\BusBundle\Form;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Job type factory
 */
class JobTypeFactory
{
    /**
     * Create entity instance
     *
     * @param string $type
     *
     * @return JobType
     * @throws \Exception
     */
    public function create($type)
    {
        $className = '\\Autobus\Bundle\BusBundle\\Form\\'.ucfirst(strtolower($type)).'JobType';

        if (!class_exists($className)) {
            throw new \Exception(sprintf('%s does not exist', $className));
        }

        return new $className;
    }
}
