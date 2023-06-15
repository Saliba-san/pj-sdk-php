<?php

namespace Inter\Banking;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class ConsultarExtratoPdf
{
    private $msg = "Chamada Iniciada - Consulta Extrato PDF";
    private $errorCallApiMessage = "Erro na Consulta Extrato PDF. ";

    private $certificado;
    private $senha;
    private $token;
    private $ambiente;
    private $debug;
    private $controleRateLimit;
    private $contaCorrente;

    public function __construct(string $certificado, string $senha, string $token, string $ambiente, string $contaCorrente = null,
                                bool   $debug = false, bool $controleRateLimit = true)
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
     * @throws ClientException
     * @throws ServerException
     */
    final public function call(string $dataInicio, string $dataFim, string $path): void
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK . DATA_INICIO . $dataInicio . LINE_BREAK . DATA_FIM . $dataFim);

        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_BANKING);
        $configPath = ConfigUtils::getPath(API_TYPE_BANKING, API_ENDPOINT_PATH_EXTRATO_PDF);

        $METHOD = $configPath[METHOD];
        $URL = $baseUrl . $configPath[ROUTE];

        $URL .= DATA_INICIO_QUERY . $dataInicio . DATA_FIM_QUERY . $dataFim;

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        $body = json_decode($http_response->getBody(), false, 512);

        $pdf_decoded = base64_decode($body->pdf);

        file_put_contents($path, $pdf_decoded, LOCK_EX);
    }

}