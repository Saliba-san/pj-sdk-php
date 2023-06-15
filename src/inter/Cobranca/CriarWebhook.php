<?php

namespace Inter\Cobranca;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class CriarWebhook
{
    private $msg = "Chamada Iniciada - Criar Webhook Cobrança";
    private $errorCallApiMessage = "Erro ao Criar Webhook do Cobrança. ";
    private $content_type = 'application/json';
    private $body_parameter = 'webhookUrl';

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
    final public function call(string $webhookUrl): void
    {
        LogUtils::logMsg($this->msg);

        $configurations = HttpUtils::getConfigurations();
        $body = $this->getBody($webhookUrl, $this->debug);
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            $body, $this->content_type, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_COBRANCA);
        $path = ConfigUtils::getPath(API_TYPE_COBRANCA, API_ENDPOINT_PATH_PUT_WEBHOOK);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);
    }

    final public function getBody(string $webhookUrl, bool $debug = false): string
    {
        $body = json_encode([
            $this->body_parameter => $webhookUrl
        ]);

        if ($debug) {
            LogUtils::logMsg(REQUEST_BODY . $body . LINE_BREAK);
        }

        return $body;
    }

}
