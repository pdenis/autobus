<?php

namespace Autobus\Bundle\BusBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Service
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="Autobus\Bundle\BusBundle\Repository\JobRepository")
 * @UniqueEntity("path")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"job_web" = "WebJob", "job_queue" = "QueueJob", "job_cron" = "CronJob"})
 * @ORM\HasLifecycleCallbacks()
 *
 *
 */
abstract class Job
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
    protected $runner;

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
     * @var array
     */
    protected $configArray;

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
     * @ORM\OneToMany(targetEntity="Autobus\Bundle\BusBundle\Entity\Execution", mappedBy="job")
     */
    protected $executions;

    public function __construct()
    {
        $this->executions = new ArrayCollection();
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
     * @return Job
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
     * @param string $runner
     *
     * @return Job
     */
    public function setRunner($runner)
    {
        $this->runner = $runner;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getRunner()
    {
        return $this->runner;
    }

    /**
     * @param string $path
     *
     * @return Job
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
     * @return Job
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
        if (null === $this->configArray) {
            $this->configArray = json_decode($this->config, true);
        }

        return $this->configArray;
    }

    /**
     * @param array $config
     *
     * @return Job
     */
    public function setConfigArray($config)
    {
        $this->configArray = $config;
        $this->config = json_encode($config);

        return $this;
    }

    /**
     * @param boolean $trace
     *
     * @return Job
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
     * @param mixed $executions
     *
     * @return Job
     */
    public function setExecutions($executions)
    {
        $this->executions = $executions;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExecutions()
    {
        return $this->executions;
    }

    /**
     * @param mixed $createdAt
     *
     * @return Job
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
     *
     * @return Job
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
