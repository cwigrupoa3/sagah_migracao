<?php

//CRIAR O TRANSACTION CONTROL
//TESTAR

namespace App\Service\Base\Abstracts;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use App\Entity\Aplicacao;
use App\Service\Base\Interfaces\EntityInterface;
use App\Service\Base\Interfaces\ManipuladorRulesInterface;
use App\Service\TransactionControl\TransactionControl;

/**
 * Class AbstractManipulador
 */
abstract class AbstractManipulador
{
    const FLUSHENTITY = 'entity';
    const FLUSHALL = 'all';

    private $flushMode = self::FLUSHENTITY;
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;
    /**
     * @var TransactionControlService
     */
    protected $tControl;
    /**
     * @var ManipuladorRulesInterface
     */
    protected $rules;
    /**
     * @var Aplicacao
     */
    protected $aplicacao;
    /**
     * @var EntityRepository
     */
    protected $repository;

    //--------------------------------------------------------------------------------------------------------//

    /**
     * 
     */
    public function __construct(
        \Doctrine\ORM\EntityManagerInterface $em, 
        \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage, 
        TransactionControl $transactionControl
    )
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->tControl = $transactionControl;

        $this->aplicacao = $this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null;
    }

    //--------------------------------------------------------------------------------------------------------//

    private function carregarRules()
    {
        if (!$this->rules) {
            $this->rules = $this->getRules();
        }
    }

    //--------------------------------------------------------------------------------------------------------//

    abstract protected function getRules() : ManipuladorRulesInterface;

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @param EntityInterface $entity
     */
    public function prepararParaSalvar(EntityInterface $entity)
    {
        $this->carregarRules();

        $this->rules->validarSalvar($entity);

        return $entity;
    }

    /**
     * @param EntityInterface $entity
     */
    public function salvar(EntityInterface $entity)
    {
        $this->prepararParaSalvar($entity);

        $this->em->persist($entity);

        if ($this->flushMode == self::FLUSHENTITY) {
            $this->em->flush($entity);
        } else if ($this->flushMode == self::FLUSHALL) {
            $this->em->flush();
        }
    }

    /**
     * @param EntityInterface $entity
     */
    public function excluir(EntityInterface $entity)
    {
        $this->carregarRules();

        $this->rules->validarExcluir($entity);

        $this->em->remove($entity);

        $this->em->flush();
    }

    /**
     * @return TransactionControl
     */
    public function getTransactionControl(): TransactionControl
    {
        return $this->tControl;
    }

    /**
     * @param $flushMode
     * @return $this
     */
    function setFlushMode($flushMode)
    {
        $this->flushMode = $flushMode == self::FLUSHENTITY ? self::FLUSHENTITY : self::FLUSHALL;

        return $this;
    }
}