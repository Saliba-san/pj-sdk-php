<?php

namespace Inter\Cobranca;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\BoletoBody;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use stdClass;

class EmitirBoletoDeCobranca
{
    private $msg = "Chamada Iniciada - Emitir BoletoBody de Cobrança";
    private $errorCallApiMessage = "Erro ao Emitir BoletoBody de Cobrança. ";
    private $content_type = 'application/json';

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
    final public function call(BoletoBody $body): stdClass
    {
        LogUtils::logMsg($this->msg);

        $configurations = HttpUtils::getConfigurations();
        $bodyRequest = $this->getBody($body, $this->debug);
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            $bodyRequest, $this->content_type, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_COBRANCA);
        $path = ConfigUtils::getPath(API_TYPE_COBRANCA, API_ENDPOINT_PATH_EMITIR_BOLETO);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }

    final public function getBody(BoletoBody $body, bool $debug = false): string
    {
        $jsonBody = json_encode($body);

        if ($debug) {
            LogUtils::logMsg(REQUEST_BODY . $jsonBody . LINE_BREAK);
        }

        return $jsonBody;
    }

}
