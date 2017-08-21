<?php

namespace BusBundle\EventListener;

use BusBundle\Event\BusServiceEvents;
use BusBundle\Event\BusServiceHandleEvent;
use BusBundle\Service\SecureWebService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class SecureWebServiceSubscriber
 */
class SecureWebServiceSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            BusServiceEvents::BEFORE_HANDLE => array('onBeforeHandle', 64)
        );
    }

    public function onBeforeHandle(BusServiceHandleEvent $event)
    {
        $service = $event->getService();
        $request = $event->getRequest();

        if ($service instanceof SecureWebService && $service->isSecure()) {
            $config = $service->getConfigArray();

            $security = $config['security'];

            if (!is_array($security['mode'])) {
                $security['mode'] = [$security['mode']];
            }

            if (array_key_exists('http_basic', $security['mode'])) {
                $this->checkHttpBasicAuth($request, $config);
            }

            if (array_key_exists('ip_whitelist', $security['mode'])) {
                $this->checkIpWhitelistAuth($request, $config);
            }
        }
    }

    /**
     * @param Request $request
     * @param array $config
     */
    protected function checkHttpBasicAuth($request, $config)
    {
        $requestUser = $request->getUser();
        $requestPass = $request->getPassword();

        $configUser = $config['security']['mode']['http_basic']['username'];
        $configPass = $config['security']['mode']['http_basic']['password'];

        if ($requestUser != $configUser || $requestPass != $configPass) {
            throw new AuthenticationException(sprintf('Invalid credentials for user [%s]', $requestUser));
        }
    }

    /**
     * @param Request $request
     * @param array $config
     */
    protected function checkIpWhitelistAuth($request, $config)
    {
        $clientIp = $request->getClientIp();
        $allowedIps = (array)$config['security']['mode']['ip_whitelist'];

        if (!IpUtils::checkIp($clientIp, $allowedIps)) {
            throw new AuthenticationException(sprintf('Unauthorized IP address [%s]', $clientIp));
        }
    }
}
