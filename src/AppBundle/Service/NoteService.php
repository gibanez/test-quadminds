<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 17/1/2018
 * Time: 03:58
 */

namespace AppBundle\Service;

use AppBundle\Entity\Note;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

class NoteService
{
    const NAME = 'Note.Service';
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    /**
     * NoteService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(Note::class);
    }

    /**
     * Find Client on repository
     *
     * @param $id
     * @return null|Note
     * @throws EntityNotFoundException
     */
    public function find($id)
    {
        $note = $this->repo->find($id);
        if (!$note instanceof Note) {
            throw new EntityNotFoundException("Note not found");
        }

        return $note;
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
        $notes = $this->repo->findAll();

        return $notes;
    }

    /**
     * Save Client on repository (INSERT|UPDATE)
     *
     * @param Note $note
     */
    public function doSave(Note $note)
    {
        if($note->isNew())
        {
            $this->entityManager->persist($note);
        }

        $this->entityManager->flush();
    }

    /**
     * Remove Note from repository
     * @param Note $note
     */
    public function doDelete(Note $note)
    {
        $this->entityManager->remove($note);
        return $this->entityManager->flush();

    }
}