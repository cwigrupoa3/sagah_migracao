<?php

namespace App\Service\Base\Interfaces;

/**
 * 
 */
interface CarregadorInterface
{
    /**
     * @return array
     */
    public function findAll() : array;

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) : array;

    /**
     * @param int $id
     * @return null|object
     */
    public function find($id);

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return null|object
     */
    public function findOneBy(array $criteria, array $orderBy = null);
}