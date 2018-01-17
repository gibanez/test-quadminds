<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Form\ClienteType;
use AppBundle\Service\ClientService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View;


/**
 * Class API/REST of Cliente
 *
 * Class ClientController
 * @package AppBundle\Controller
 */
class ClientController extends FOSRestController
{
    /**
     * @Rest\Get("/client")
     */
    public function listAction()
    {
        $clientService = $this->getService();

        try
        {
            $clients = $clientService->findAll();
            return new View($clients, Response::HTTP_OK);
        }
        catch (\Exception $e)
        {
            return new View("Clients not found", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Rest\Get("/client/{id}")
     */
    public function getAction($id)
    {

        $clientService = $this->getService();

        try{

            /**
             * @var $client Cliente
             */
            $client = $clientService->find($id);

            return new View($client, Response::HTTP_OK);

        }
        catch (\Exception $e)
        {
            return new View("Client not found", Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * @Rest\Post("/client")
     */
    public function createAction(Request $request)
    {
        $client = new Cliente();

        return $this->processClient($client, $request);
    }

    /**
     * @Rest\Put("/client/{id}")
     */
    public function editAction($id, Request $request)
    {
        try {
            $clientService = $this->getService();
            /**
             * @var $client Cliente
             */
            $client = $clientService->find($id);
            return $this->processClient($client, $request);
        }
        catch (\Exception $e)
        {
            return new View("Client not found", Response::HTTP_NOT_FOUND);
        }



    }

    /**
     * @Rest\Delete("/client/{id}")
     */
    public function deleteAction($id)
    {

        try {
            $clientService = $this->getService();
            /**
             * @var $client Cliente
             */
            $client = $clientService->find($id);

            $clientService->doDelete($client);

            return new View("deleted successfully", Response::HTTP_OK);
        }
        catch (\Exception $e)
        {
            return new View("Client not found", Response::HTTP_NOT_FOUND);
        }

    }

    private function processClient(Cliente $client, Request $request)
    {

        $statusCode = $client->isNew()?Response::HTTP_CREATED:Response::HTTP_NO_CONTENT;
        $form = $this->createForm(ClienteType::class, $client);

        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if($client->isNew())
            {
                $em->persist($client);
            }
            $em->flush();

            return new View($client, $statusCode);
        }
        return new View($form, Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @return ClientService
     */
    private function getService()
    {
        /**
         * @var $clientService ClientService
         */
        $clientService = $this->get(ClientService::NAME);


        return $clientService;
    }

}