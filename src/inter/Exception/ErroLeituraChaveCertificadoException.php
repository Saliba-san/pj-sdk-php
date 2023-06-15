<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class ErroLeituraChaveCertificadoException extends ClientException
{
    public function __construct()
    {
        $DOC_CERTIFICATE = "https://developers.bancointer.com.br/v4/docs/onde-obter-o-certificado";
        $message = "Erro na leitura dos dados da chave do certificado .key.";
        $format =  $message." Consulte %s.";
        $format = sprintf($format, $DOC_CERTIFICATE);
        $erro = new Erro($message, $format);

        parent::__construct($format, $erro);
    }

}