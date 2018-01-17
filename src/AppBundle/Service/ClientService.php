<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 17/1/2018
 * Time: 03:58
 */

namespace AppBundle\Service;


use AppBundle\Entity\Cliente;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\DependencyInjection\Container;

class ClientService
{
    const NAME = 'Client.Service';
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(Cliente::class);
    }

    /**
     * Find Client on repository
     *
     * @param $id
     * @return null|Cliente
     * @throws EntityNotFoundException
     */
    public function find($id)
    {
        $client = $this->repo->find($id);
        if (!$client instanceof Cliente) {
            throw new EntityNotFoundException("Client not found");
        }

        return $client;
    }

    /**
     * @param array $filter
     * @param int $offset
     * @param int $limit
     * @return array
     * @throws EntityNotFoundException
     */
    public function findAll($filter = [], $offset = 1, $limit = 10)
    {
        $clients = $this->repo->findAll();

        if(count($clients) === 0)
        {
            throw new EntityNotFoundException("Clients not found");
        }

        return $clients;
    }

    /**
     * Save Client on repository (INSERT|UPDATE)
     *
     * @param Cliente $client
     */
    public function doSave(Cliente $client)
    {
        if($client->isNew())
        {
            $this->entityManager->persist($client);
        }

        $this->entityManager->flush();
    }

    /**
     * Remove Client from repository
     * @param Cliente $client
     */
    public function doDelete(Cliente $client)
    {
        $this->entityManager->remove($client);
        return $this->entityManager->flush();

    }
}