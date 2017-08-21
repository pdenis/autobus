<?php

namespace Autobus\Bundle\BusBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WebService
 *
 * @ORM\Table(name="job_web")
 * @ORM\Entity(repositoryClass="Autobus\Bundle\BusBundle\Repository\WebJobRepository")
 */
class WebJob extends Job
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
     *
     * @return WebJob
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
     *
     * @return WebJob
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
