<?php

namespace Inter\Exception;

use Exception;
use Inter\Model\Erro;

class SdkException extends Exception
{
    private $erro;

    public function __construct($message, Erro $erro)
    {
        $this->erro = $erro;
        parent::__construct($message);
    }

    final public function getErro () {
        return $this->erro;
    }

}