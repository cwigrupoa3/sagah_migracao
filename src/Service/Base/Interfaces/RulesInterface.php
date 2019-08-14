<?php

namespace App\Service\Base\Interfaces;

use App\Exceptions\SagahMigracaoException;

interface RulesInterface
{

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @param SagahMigracaoException $exception
     * @return mixed
     */
    public function setException(SagahMigracaoException $exception): RulesInterface;

    /**
     * @return SagahMigracaoException
     */
    public function getException($code, $message): SagahMigracaoException;
}