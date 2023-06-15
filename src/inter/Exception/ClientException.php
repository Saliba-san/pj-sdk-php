<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class ClientException extends SdkException
{
    public function __construct($message, Erro $erro)
    {
        parent::__construct($message, $erro);
    }

}