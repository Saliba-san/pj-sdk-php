<?php

namespace Inter\Banking;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use stdClass;

class BuscaSaldo
{
    private $query = "?dataSaldo=";
    private $msg = "Chamada Iniciada - Busca Saldo";
    private $errorCallApiMessage = "Erro na Busca de Saldo. ";

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
    final public function call(string $date = null): stdClass
    {
        LogUtils::logMsg($this->msg);

        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, null, null, $this->contaCorrente);
        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_BANKING);
        $path = ConfigUtils::getPath(API_TYPE_BANKING, API_ENDPOINT_PATH_SALDO);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        if ($date !== null) {
            $URL .= $this->query . $date;
            LogUtils::logMsg(PARAMETROS . LINE_BREAK . DATA . $date);
        }

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }

}