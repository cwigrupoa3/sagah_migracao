<?php

namespace App\Exceptions\Errors;

/**
 * SagahMigracaoExceptionError
 */
class SagahMigracaoExceptionError implements ISagahMigracaoExceptionError
{        
    private         $code;
    private         $message;

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public function getCode() :string
    {
        return $this->code;
    }

    public function getMessage() :string
    {
        return $this->message;
    }

    public function setCode($code) :ISagahMigracaoExceptionError
    {
        $this->code = $code;

        return $this;
    }

    public function setMessage($msg) :ISagahMigracaoExceptionError
    {
        $this->message = $msg;

        return $this;
    }

    public function getArray() :array
    {
        
        return array(
            'code'      => $this->code,
            'message'   => $this->message
        );
    }
}