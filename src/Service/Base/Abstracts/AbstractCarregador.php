<?php
namespace App\Service\Base\Abstracts;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Service\Base\Interfaces\CarregadorInterface;

/**
 * Class AbstractCarregador
 */
abstract class AbstractCarregador implements CarregadorInterface
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var EntityRepository
     */
    protected $repository;

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @param EntityManager $em
     * @param string        $repositoryName
     */
    public function __construct(EntityManagerInterface $em, $repositoryName)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository($repositoryName);
    }

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @return array
     */
    public function findAll() : array
    {
        return $this->repository->findAll();
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) : array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param int $id
     * @return null|object
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return null|object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->repository->findOneBy($criteria, $orderBy);
    }
}