<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class ServerException extends SdkException
{
    public function __construct($message, Erro $erro)
    {
        parent::__construct($message, $erro);
    }

}