<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class ErroLeituraCertificadoException extends ClientException
{
    public function __construct(string $message)
    {
        $DOC_CERTIFICATE = "https://developers.bancointer.com.br/v4/docs/onde-obter-o-certificado";
        $format =  $message." Consulte %s.";
        $format = sprintf($format, $DOC_CERTIFICATE);
        $erro = new Erro($message, $format);

        parent::__construct($format, $erro);
    }

}