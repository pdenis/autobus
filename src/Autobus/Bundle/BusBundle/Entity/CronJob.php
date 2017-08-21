<?php

namespace Autobus\Bundle\BusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CronJob
 *
 * @ORM\Table(name="cron_job")
 * @ORM\Entity(repositoryClass="Autobus\Bundle\BusBundle\Repository\CronJobRepository")
 */
class CronJob extends Job
{
    /**
     * @var array
     *
     * @ORM\Column(name="schedule", type="string", nullable=false)
     */
    protected $schedule;

    /**
     * @param array $schedule
     * @return CronService
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return array
     */
    public function getSchedule()
    {
        return $this->schedule;
    }
}
