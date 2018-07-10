<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Form\NoteType;
use AppBundle\Service\NoteService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Class API/REST of Cliente
 *
 * Class ClientController
 * @package AppBundle\Controller
 */
class NoteController extends FOSRestController
{

    private $headers = [
        'Access-Control-Allow-Credentials' => true,
        'Access-Control-Allow-Origin' => '*'
    ];
    
    /**
     * @var NoteService
     */
    private $NoteService;

    /**
     * @Rest\Get("/api/notes")
     */
    public function listNote()
    {

        $notes = $this->NoteService->findAll();

        $response = [
            'data' => $notes
        ];
        return new View($response, Response::HTTP_OK, $this->headers);

    }

    /**
     * @Rest\Get("/api/notes/{id}")
     */
    public function getNote($id)
    {

        try {
            $note = $this->NoteService->find($id);
            return new View($note, Response::HTTP_OK, $this->headers);
        }
        catch (\Exception $e)
        {
            return $this->sendError($e->getMessage());
        }

    }

    /**
     * @Rest\Post("/api/notes", options={"method_prefix" = false})
     */
    public function createNote(Request $request)
    {
        $note = new Note();
        return $this->processClient($note, $request);
    }

    /**
     * @Rest\Delete("/api/notes/{note}")
     */
    public function removeNote(Note $note)
    {
        try {
            $this->NoteService->doDelete($note);
            return new View(['data' => true], Response::HTTP_OK);
        }
        catch (\Exception $e)
        {
            return new View(['data' => false], Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Put("/api/notes/{id}")
     * @param Request $request
     * @return View
     */
    public function editNote($id, Request $request)
    {
        try {

            $note = $this->NoteService->find($id);
            return $this->processClient($note, $request);
        }
        catch (\Exception $e)
        {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;


        $this->NoteService = $this->container->get(NoteService::NAME);
    }

    private function processClient(Note $note, Request $request)
    {
        $form = $this->createForm(NoteType::class, $note);
        if(!$note->isNew())
        {
            $request->request->remove('id');
        }
        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if($note->isNew())
            {
                $em->persist($note);
            }

            try {
                $em->flush();
            }
            catch (\Exception $e)
            {
                return $this->sendError($e->getMessage());
            }

            $response = [
                'data' => $note
            ];

            return new View($response, Response::HTTP_OK, $this->headers);
        }

        var_dump($form->getErrors());
        foreach ($form->getErrors() as $error) {
            var_dump(get_class($error));
        }
        return $this->sendError($form);

        //return new View($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE, $this->headers);
    }

    private function sendError($message)
    {
        return new View(['message' => $message], Response::HTTP_OK, $this->headers);
    }

}
