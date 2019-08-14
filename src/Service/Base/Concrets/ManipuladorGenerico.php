<?php

namespace App\Service\Base\Concrets;

use App\Service\Base\Abstracts\AbstractManipulador;

/**
 * ManipuladorGenerico
 */
class ManipuladorGenerico extends AbstractManipulador
{
    /**
     * @var \App\Service\Base\Interfaces\ManipuladorInterface
     */
    private $manipulador;

    //--------------------------------------------------------------------------------------------------------//

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em, \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage, \App\Service\TransactionControl\TransactionControl $transactionControl)
    {
        parent::__construct($em, $tokenStorage, $transactionControl);
    }

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    protected function getRules(): \App\Service\Base\Interfaces\ManipuladorRulesInterface
    {
        return $this->manipulador->getRules();
    }

    //--------------------------------------------------------------------------------------------------------//

    public function setManipulador(\App\Service\Base\Interfaces\ManipuladorInterface $manipulador)
    {
        $this->manipulador = $manipulador;
    }
}