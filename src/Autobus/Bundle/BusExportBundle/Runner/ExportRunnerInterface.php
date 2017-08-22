<?php

namespace Autobus\Bundle\BusExportBundle\Runner;

/**
 * Interface ExportRunnerInterface
 */
interface ExportRunnerInterface
{
    /**
     * @return array
     */
    public function getData();

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @return string
     */
    public function getFormat();
}
