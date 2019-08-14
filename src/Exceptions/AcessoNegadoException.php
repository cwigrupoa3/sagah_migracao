<?php

namespace App\Exceptions;

use App\Exceptions\SagahMigracaoException;

/**
 * AcessoNegadoException
 */
class AcessoNegadoException extends SagahMigracaoException
{
    const MESSAGE = 'Acesso negado';
    const CODE = '04001';

    //--------------------------------------------------------------------------------------------------------//

    public function __construct()
    {
        parent::__construct(SagahMigracaoException::LEVEL_ERROR, self::MESSAGE, self::CODE);

        $this->genError(self::CODE, self::MESSAGE);
    }
    
    //--------------------------------------------------------------------------------------------------------//
    
    //--------------------------------------------------------------------------------------------------------//
    
    //--------------------------------------------------------------------------------------------------------//

}