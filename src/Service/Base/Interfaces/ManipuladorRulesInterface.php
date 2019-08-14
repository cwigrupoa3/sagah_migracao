<?php

namespace App\Service\Base\Interfaces;

use App\Exceptions\SagahMigracaoException;
use App\Service\Base\Interfaces\EntityInterface;

/**
 * Interface ManipuladorRulesInterface
 */
interface ManipuladorRulesInterface extends RulesInterface
{

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @param AbstractEntity $entity
     */
    public function validarSalvar(EntityInterface $entity);

    /**
     * @param AbstractEntity $entity
     */
    public function validarExcluir(EntityInterface $entity);
}