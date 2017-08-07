<?php

namespace BusBundle\Form;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Service type factory
 */
class ServiceTypeFactory
{
    /**
     * Create entity instance
     *
     * @param string $type
     *
     * @return ServiceType
     * @throws \Exception
     */
    public function create($type)
    {
        $className = '\\BusBundle\\Form\\'.ucfirst(strtolower($type)).'ServiceType';

        if (!class_exists($className)) {
            throw new \Exception(sprintf('%s does not exist', $className));
        }

        return new $className;
    }
}
