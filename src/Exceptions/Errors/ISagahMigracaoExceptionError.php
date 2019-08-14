<?php

namespace App\Exceptions\Errors;

/**
 *
 */
interface ISagahMigracaoExceptionError
{
    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public function setCode($code) :ISagahMigracaoExceptionError;

    public function getCode() :string;

    public function setMessage($msg) : ISagahMigracaoExceptionError;

    public function getMessage() :string;

    public function getArray() :array;
}