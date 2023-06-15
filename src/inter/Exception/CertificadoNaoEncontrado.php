<?php

namespace Inter\Exception;

use Inter\Model\Erro;

class CertificadoNaoEncontrado extends ClientException
{
    public function __construct(string $cert_path)
    {
        $message = "Certificado não encontrado.";
        $format = $message." Ele está no seguinte diretório? %s";
        $format = sprintf($format, $cert_path);
        $erro = new Erro($message, $format);

        parent::__construct($format, $erro);
    }

}