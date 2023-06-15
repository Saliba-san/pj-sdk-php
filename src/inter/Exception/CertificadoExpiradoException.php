<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class CertificadoExpiradoException extends ClientException
{
    public function __construct($validTo)
    {
        $DOC_CERTIFICATE = "https://developers.bancointer.com.br/v4/docs/onde-obter-o-certificado";
        $message = "Certificado expirado";
        $format = $message." em %s. Consulte %s.";
        $format = sprintf($format, $validTo, $DOC_CERTIFICATE);
        $erro = new Erro($message, $format);
        parent::__construct($format, $erro);
    }

}