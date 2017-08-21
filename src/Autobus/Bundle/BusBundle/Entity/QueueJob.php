<?php

namespace Autobus\Bundle\BusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * QueueService
 *
 * @ORM\Table(name="job_queue")
 * @ORM\Entity(repositoryClass="Autobus\Bundle\BusBundle\Repository\QueueJobRepository")
 */
class QueueJob extends Job
{
}
