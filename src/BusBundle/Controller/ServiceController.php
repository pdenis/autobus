<?php

namespace BusBundle\Controller;

use BusBundle\Entity\Service;
use BusBundle\Entity\ServiceCall;
use BusBundle\Entity\WebService;
use BusBundle\Service\BusServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller
{
    /**
     * Lists all service entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('BusBundle:Service')->findAll();

        return $this->render('BusBundle::service/index.html.twig', array(
            'services' => $services,
        ));
    }

    /**
     * Creates a new service entity.
     *
     */
    public function newAction(Request $request)
    {
        $type = $request->get('service_type', '');
        if (empty($type)) {
            return $this->render('BusBundle::service/new.html.twig', []);
        }

        $service = $this->get('bus.service.factory')->create($type);
        $formType = $this->get('bus.form.service.factory')->create($type);
        $form = $this->createForm(get_class($formType), $service, ['service_chain' => $this->get('BusBundle\Service\ServiceChain')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service_show', array('id' => $service->getId()));
        }

        return $this->render('BusBundle::service/new.html.twig', array(
            'service' => $service,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a service entity.
     *
     */
    public function showAction(Service $service)
    {
        $deleteForm = $this->createDeleteForm($service);

        return $this->render('BusBundle::service/show.html.twig', array(
            'service' => $service,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing service entity.
     *
     */
    public function editAction(Request $request, Service $service)
    {
        $deleteForm = $this->createDeleteForm($service);
        $editForm = $this->createForm('BusBundle\Form\ServiceType', $service);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_edit', array('id' => $service->getId()));
        }

        return $this->render('BusBundle::service/edit.html.twig', array(
            'service' => $service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a service entity.
     *
     */
    public function deleteAction(Request $request, Service $service)
    {
        $form = $this->createDeleteForm($service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_index');
    }

    /**
     * Call service
     */
    public function callAction(Request $request, Service $service)
    {
        $serviceClass = $service->getService();
        /** @var BusServiceInterface $serviceInstance */
        $serviceInstance = $this->get($serviceClass);

        if (!$service) {
            return new Response('', 404);
        }

        $response = new Response();
        $serviceCall = new ServiceCall();

        try {
            $serviceInstance->beforeHandle($request, $service, $serviceCall);
            $serviceInstance->handle($request, $response, $service, $serviceCall);
            $serviceCall->setState($serviceCall::STATE_SUCCESS);
        } catch (BadRequestHttpException $e) {
            $response->setContent($e->getMessage());
            $response->setStatusCode(400);
        } catch (AuthenticationException $e) {
            $response->setContent($e->getMessage());
            $response->setStatusCode(401);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        } finally {
            $serviceInstance->afterHandle($request, $response, $service, $serviceCall, $this->get('logger'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($serviceCall);
            $em->flush();
        }

        return $response;
    }

    /**
     * Creates a form to delete a service entity.
     *
     * @param Service $service The service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Service $service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_delete', array('id' => $service->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
