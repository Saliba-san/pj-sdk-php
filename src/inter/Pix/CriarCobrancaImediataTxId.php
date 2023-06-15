<?php

namespace Inter\Pix;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\CobrancaBody;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use stdClass;

class CriarCobrancaImediataTxId
{
    private $msg = "Chamada Iniciada - Criar Cobrança Imediata TxId";
    private $errorCallApiMessage = "Erro ao Criar Cobrança Imediata TxId. ";
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
    final public function callCobrancaBody(CobrancaBody $body, string $txId): stdClass
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK . TXID . $txId);

        $configurations = HttpUtils::getConfigurations();
        $bodyRequest = $this->getBody($body, $this->debug);
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, $bodyRequest,
            $this->content_type, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_PIX);
        $path = ConfigUtils::getPath(API_TYPE_PIX, API_ENDPOINT_PATH_PUT_COBRANCA_IMEDIATA);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE] . $txId;

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }

    final public function getBody(CobrancaBody $body, bool $debug = false): string
    {
        $jsonBody = json_encode($body);

        if ($debug) {
            LogUtils::logMsg(REQUEST_BODY . $jsonBody . LINE_BREAK);
        }

        return $jsonBody;
    }

}
