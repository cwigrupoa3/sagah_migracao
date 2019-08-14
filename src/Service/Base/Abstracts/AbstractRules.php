<?php

namespace App\Service\Base\Abstracts;

use App\Exceptions\Errors\ISagahMigracaoExceptionError;
use App\Exceptions\SagahMigracaoException;
use App\Service\Base\Interfaces\RulesInterface;

abstract class AbstractRules implements RulesInterface
{
    /**
     * @var int
     */
    private static $autoThrowCounter = 1;

    /**
     * @var bool
     */
    private $canThrow = false;

    /**
     * @var int
     */
    private $originalErrorsSize = 0;

    /**
     * @var ISagahMigracaoExceptionError
     */
    private $erroInicial;

    /**
     * @var \App\Exceptions\SagahMigracaoException
     */
    protected $exception;

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @param SagahMigracaoException $exception
     * @return mixed
     */
    public function setException(SagahMigracaoException $exception): RulesInterface
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @return SagahMigracaoException
     */
    public function getException($code, $message): SagahMigracaoException
    {

            $this->erroInicial = $this->exception->getNewError();
            $this->erroInicial->setCode('05'.$code)->setMessage($message);
            $this->exception->addError($this->erroInicial);

            $this->originalErrorsSize = sizeof($this->exception->getErrors());

            $this->canThrow = false;
            self::$autoThrowCounter++;


        return $this->exception;
    }

    public function autoThrowException()
    {
        if ($this->canThrow) {
            $this->exception->autoThrow(self::$autoThrowCounter);
        } else if ($this->originalErrorsSize == sizeof($this->exception->getErrors())) {
            $this->exception->removeError($this->erroInicial);
            self::$autoThrowCounter--;
        }
    }
}