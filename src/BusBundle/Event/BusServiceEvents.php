<?php

namespace BusBundle\Event;

/**
 * Class BusServiceEvents
 */
final class BusServiceEvents
{
    const BEFORE_HANDLE = 'bus_service.before_handle';

    const AFTER_HANDLE = 'bus_service.after_handle';

    const ERROR = 'bus_service.error';

    const SUCCESS = 'bus_service.success';
}
