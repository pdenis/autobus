<?php

namespace Autobus\Bundle\BusExportBundle\Converter;

use JMS\Serializer\SerializerInterface;

/**
 * class SerializeConverter
 */
abstract class SerializeConverter implements ConverterInterface
{
    private $serializer;

    protected $format;

    /**
     * @param string $format
     */
    public function __construct(SerializerInterface $serializer, $format)
    {
        $this->serializer = $serializer;
        $this->format = $format;
    }

    /**
     * @param mixed $data
     * @param array $config
     *
     * @return string
     */
    public function convert($data, array $config = array())
    {
        return $this->serializer->serialize($data, $this->format);
    }
}
