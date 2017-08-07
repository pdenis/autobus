<?php

namespace BusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CronService
 *
 * @ORM\Table(name="service_cron")
 * @ORM\Entity(repositoryClass="BusBundle\Repository\CronServiceRepository")
 */
class CronService extends Service
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
