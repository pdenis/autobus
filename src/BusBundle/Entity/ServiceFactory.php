<?php

namespace BusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Service factory
 */
class ServiceFactory
{
    /**
     * Create entity instance
     *
     * @param string $type
     *
     * @return Service
     * @throws \Exception
     */
    public function create($type)
    {
        $className = '\\BusBundle\\Entity\\'.ucfirst(strtolower($type)).'Service';

        if (!class_exists($className)) {
            throw new \Exception(sprintf('%s does not exist', $className));
        }

        return new $className;
    }
}
