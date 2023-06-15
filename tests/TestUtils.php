<?php

namespace Tests;

use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\InterSdk;

class TestUtils
{
    /**
     * @throws ErroLeituraChaveCertificadoException
     * @throws CertificadoNaoEncontrado
     * @throws ChaveNaoEncontradaException
     * @throws CertificadoExpiradoException
     * @throws ErroLeituraCertificadoException
     */
    public static function getSdk(): object
    {

        $ambiente = "";
        $clientId = "";
        $clientSecret = "";
        $certificate = "";
        $password = "";

        $sdk = new InterSdk($clientId, $clientSecret, $certificate, $password);

        $sdk->setAmbiente($ambiente);

        return $sdk;
    }

}