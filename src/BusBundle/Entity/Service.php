<?php

namespace BusBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="BusBundle\Repository\ServiceRepository")
 * @UniqueEntity("path")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"service_web" = "WebService", "service_queue" = "QueueService", "service_cron" = "CronService"})
 * @ORM\HasLifecycleCallbacks()
 *
 *
 */
abstract class Service
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255)
     */
    protected $service;

    /**
     * @var string
     *
     * @Assert\Valid()
     *
     * @ORM\Column(name="path", type="string", unique=true, length=255)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="text", nullable=true)
     */
    protected $config;

    /**
     * @var bool
     *
     * @ORM\Column(name="trace", type="boolean")
     */
    protected $trace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="BusBundle\Entity\ServiceCall", mappedBy="service")
     */
    protected $serviceCalls;

    public function __construct()
    {
        $this->serviceCalls = new ArrayCollection();
        $this->secure = false;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Service
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Service
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $path
     * @return Service
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $config JSON config
     *
     * @return Service
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * * @return array
     */
    public function getConfigArray()
    {
        return json_decode($this->config, true);
    }

    /**
     * @param array $config
     *
     * @return Service
     */
    public function setConfigArray($config)
    {
        $this->config = json_encode($config);

        return $this;
    }

    /**
     * @param boolean $trace
     * @return Service
     */
    public function setTrace($trace)
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * @param mixed $serviceCalls
     * @return Service
     */
    public function setServiceCalls($serviceCalls)
    {
        $this->serviceCalls = $serviceCalls;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceCalls()
    {
        return $this->serviceCalls;
    }

    /**
     * @param mixed $createdAt
     * @return Service
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Service
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
