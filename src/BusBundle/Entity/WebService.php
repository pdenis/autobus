<?php

namespace BusBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WebService
 *
 * @ORM\Table(name="service_web")
 * @ORM\Entity(repositoryClass="BusBundle\Repository\WebServiceRepository")
 */
class WebService extends Service
{
    /**
     * @var array
     *
     * @ORM\Column(name="methods", type="array")
     */
    protected $methods;

    /**
     * @var bool
     *
     * @ORM\Column(name="secure", type="boolean")
     */
    protected $secure;

    public function __construct()
    {
        parent::__construct();

        $this->methods = [];
    }

    /**
     * @param array $methods
     * @return Service
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param boolean $secure
     * @return Service
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSecure()
    {
        return $this->secure;
    }
}
