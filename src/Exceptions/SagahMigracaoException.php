<?php

namespace App\Exceptions;

use App\Exceptions\Errors\ISagahMigracaoExceptionError;

/**
 * SagahMigracaoException
 */
class SagahMigracaoException extends \Exception
{
    const           LEVEL_WARNING       = "warning";
    const           LEVEL_ERROR         = "error";
    const           LEVEL_ALERT         = "alert";

    protected       $debug              = false;
    protected       $errors             = array();
    protected       $level;
    protected       $_code;

    //--------------------------------------------------------------------------------------------------------//

    public function __construct($level, $message, $code) 
    {
        parent::__construct($message, $code, null);

        $error = $this->getNewError();
        $error->setCode($code)
            ->setMessage("{$message}");
        $this->addError($error);

        $this->_code = $code;

        $this->level = in_array($level, array(self::LEVEL_ERROR, self::LEVEL_ALERT, self::LEVEL_WARNING)) ? $level : self::LEVEL_ERROR;
    }

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public function hasErrors($limit=1) 
    {
        $errors = $this->getErrors();

        if(sizeof($errors) > $limit)
            return true;
        elseif($errors[0]->getCode() != $this->_code) 
            return true;

        return false;
    }

    public function getNewError() 
    {
        return new Errors\SagahMigracaoExceptionError();
    }

    public function genError($code,$message) 
    {
        $error = $this->getNewError();
        $error->setCode($code)
            ->setMessage("{$message}");

        $this->addError($error);

        return $this;
    }

    public function autoThrow($limit=1) 
    {
        if($this->hasErrors($limit)) {
            throw $this;
        }
    }

    public function addError(ISagahMigracaoExceptionError $error)
    {
        $this->errors[] = $error;

        if($this->debug)
            $this->message .= "\n".$error->getCode ().':'.$error->getMessage();
    }

    public function removeError(ISagahMigracaoExceptionError $error)
    {
        $errors = [];
        foreach ($this->errors as $exceptionError) {
            if ($exceptionError != $error) {
                $errors[] = $exceptionError;
            }
        }
        $this->errors = $errors;
    }

    public function clearErrors() 
    {
        $this->errors = array();
    }

    public function getErrors() 
    {
        return $this->errors;
    }

    public function getArray() 
    {
        $array = array(
            'level'     => $this->level,
            'errors'    => array()
        );

        foreach($this->errors as $error) {
            $array['errors'][] = $error->getArray();
        }

        return $array;
    }

    public function setDebug($debug) 
    {
        $this->debug = $debug;
        if($this->debug) {
            foreach($this->errors as $error) {
                $this->message .= "\n".$error->getCode ().':'.$error->getMessage();
            }
        }
    }
}