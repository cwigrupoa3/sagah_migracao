<?php

namespace App\Service\Base\Interfaces;

/**
 * ManipuladorInterface
 */
interface ManipuladorInterface
{

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public function getRules() : ManipuladorRulesInterface;

    public function salvar(EntityInterface $entity);

    public function excluir(EntityInterface $entity);
}