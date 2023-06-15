<?php

namespace Inter\Banking;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\IncluirPagamentoBody;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use stdClass;

class IncluirPagamentoCodigoBarras
{
    private $msg = "Chamada Iniciada - Incluir Pagamento com Código de Barras";
    private $errorCallApiMessage = "Erro ao Incluir Pagamento com Código de Barras. ";
    private $content_type = 'application/json';

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
     * @throws ClientException|ServerException
     */
    final public function call(IncluirPagamentoBody $body): stdClass
    {
        LogUtils::logMsg($this->msg);

        $configurations = HttpUtils::getConfigurations();
        $body = $this->getBody($body);
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, $body,
            $this->content_type, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_BANKING);
        $path = ConfigUtils::getPath(API_TYPE_BANKING, API_ENDPOINT_PATH_INCLUI_PAGAMENTO);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }

    final public function getBody(IncluirPagamentoBody $body): string
    {
        $jsonBody = json_encode($body);

        if ($this->debug) {
            LogUtils::logMsg(REQUEST_BODY . $jsonBody . LINE_BREAK);
        }

        return $jsonBody;
    }

}
