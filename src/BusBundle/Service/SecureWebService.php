<?php

namespace BusBundle\Service;

use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

abstract class SecureWebService extends AbstractBusService
{
    /**
     * @param Request $request
     * @param Service $service
     * @param \BusBundle\Entity\ServiceCall $serviceCall
     */
    public function beforeHandle(Request $request, Service $service, ServiceCall $serviceCall)
    {
        parent::beforeHandle($request, $service, $serviceCall);

        if ($service->isSecure()) {
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
