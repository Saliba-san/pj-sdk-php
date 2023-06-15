<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class ChaveNaoEncontradaException extends ClientException
{

    public function __construct(string $key_path)
    {
        $message = "Chave não encontrada.";
        $format = $message." Ela está no seguinte diretório? %s";
        $format = sprintf($format, $key_path);
        $erro = new Erro($message, $format);

        parent::__construct($format, $erro);
    }

}