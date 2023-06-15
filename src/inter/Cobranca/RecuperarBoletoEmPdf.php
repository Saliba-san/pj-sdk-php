<?php

namespace Inter\Cobranca;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class RecuperarBoletoEmPdf
{
    private $msg = "Chamada Iniciada - Recuperar BoletoBody em PDF";
    private $errorCallApiMessage = "Erro ao Recuperar BoletoBody em PDF. ";

    private $certificado;
    private $senha;
    private $token;
    private $ambiente;
    private $debug;
    private $controleRateLimit;
    private $contaCorrente;

    public function __construct(string $certificado, string $senha, string $token, string $ambiente,
                                string $contaCorrente = null, bool $debug = false, bool $controleRateLimit = true)
    {
        $this->certificado = $certificado;
        $this->senha = $senha;
        $this->token = $token;
        $this->ambiente = $ambiente;
        $this->debug = $debug;
        $this->controleRateLimit = $controleRateLimit;
        $this->contaCorrente = $contaCorrente;
    }

    /**
     * @throws ClientException|ServerException
     */
    final public function call(string $nossoNumero, string $path): void
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK . NOSSO_NUMERO . $nossoNumero);

        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, null,
            null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_COBRANCA);
        $configPath = ConfigUtils::getPath(API_TYPE_COBRANCA, API_ENDPOINT_PATH_BOLETO_PDF);

        $METHOD = $configPath[METHOD];
        $URL = $baseUrl . $configPath[ROUTE];

        $URL = sprintf($URL, $nossoNumero);

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        $body = json_decode($http_response->getBody(), false);

        $pdf_decoded = base64_decode($body->pdf);

        file_put_contents($path, $pdf_decoded, LOCK_EX);
    }

}