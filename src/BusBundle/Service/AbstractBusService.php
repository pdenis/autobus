<?php


namespace BusBundle\Service;


use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractBusService implements BusServiceInterface
{
    /**
     * @param Request $request
     * @param Service $service
     * @param ServiceCall $serviceCall
     */
    public function beforeHandle(Request $request, Service $service, ServiceCall $serviceCall)
    {
        $serviceCall
          ->setDate(new \DateTime())
          ->setCaller($request->getClientIp())
          ->setService($service)
          ->start();

        $allowedMethods = $service->getMethods();
        if (!empty($allowedMethods) && !in_array($request->getMethod(), $allowedMethods)) {
            throw new BadRequestHttpException(sprintf('Method [%s] not allowed (allowed methods: %s]', $request->getMethod(), implode(', ', $allowedMethods)));
        }
    }

    abstract public function handle(Request $request, Response $response, Service $service, ServiceCall $serviceCall);

    /**
     * @param Request $request
     * @param Response $response
     * @param Service $service
     * @param ServiceCall $serviceCall
     * @param Logger $logger
     * @return Response
     */
    public function afterHandle(Request $request, Response $response, Service $service, ServiceCall $serviceCall, Logger $logger)
    {
        $serviceCall->finish();

        if ($response->getStatusCode() >= 400) {
            $serviceCall->setState($serviceCall::STATE_ERROR);
        }

        if ($service->getTrace()) {
            $logs = $logger->getLogs();
            $logs = array_map(function($log) {
                return sprintf('%s [%s] %s', $log['timestamp'], $log['priorityName'], $log['message']);
            }, $logs);
            $serviceCall->setLogs(implode("\n", $logs));

            $requestString = $request->headers->__toString();
            $requestString .= "\n\n".$request->getContent();
            $serviceCall->setRequest($requestString);

            $responseString = sprintf("HTTP %d\n\n", $response->getStatusCode());
            $responseString .= $response->headers->__toString();
            $responseString .= "\n\n".$response->getContent();
            $serviceCall->setResponse($responseString);
        }

        if ($request->getContentType() == 'xml') {
            $response->setContent('<result><![CDATA['.$response->getContent().']]></result>');
        } elseif ($request->getContentType() == 'json') {
            $response->setContent(sprintf('{"result":"%s"}', addslashes($response->getContent())));
        }

        return $response;
    }
}
