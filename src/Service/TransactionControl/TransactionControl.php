<?php

namespace App\Service\TransactionControl;

use Doctrine\ORM\EntityManagerInterface;

class TransactionControl implements Interfaces\TransactionControlInterface
{
    private         $em;
    private         $conn;
    private         $tPass              = '';

    //--------------------------------------------------------------------------------------------------------//

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em   = $entityManager;
        $this->conn = $this->em->getConnection();
    }

    //--------------------------------------------------------------------------------------------------------//

    private function isUnderTransaction() 
    {
        return ($this->tPass != '');
    }

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public function commitTransaction($pass) 
    {
        if($this->isUnderTransaction() && $pass == $this->tPass) {
            $this->conn->commit();
            $this->tPass = '';
        }
    }

    public function rollbackTransaction() 
    {
        if($this->isUnderTransaction()) {
            $this->conn->rollback();
        }
    }

    public function startTransaction() 
    {
        if($this->isUnderTransaction()) {
            return '';
        }

        $this->tPass = microtime(true).rand(0, 1000);

        $this->conn->beginTransaction();

        return $this->tPass;
    }
}