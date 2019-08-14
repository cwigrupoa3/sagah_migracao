<?php
/**
 * Created by PhpStorm.
 * User: rodrigoalecio
 * Date: 23/04/2018
 * Time: 16:12
 */

namespace App\Service\Base\Abstracts;

use App\Service\Base\Interfaces\EntityInterface;
use App\Service\Base\Interfaces\ManipuladorRulesInterface;

abstract class AbstractManipuladorRules extends AbstractRules implements ManipuladorRulesInterface
{

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @inheritDoc
     */
    public function validarSalvar(EntityInterface $entity)
    {}

    /**
     * @inheritDoc
     */
    public function validarExcluir(EntityInterface $entity)
    {}
}