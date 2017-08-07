<?php

namespace BusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * QueueService
 *
 * @ORM\Table(name="service_queue")
 * @ORM\Entity(repositoryClass="BusBundle\Repository\QueueServiceRepository")
 */
class QueueService extends Service
{
}
