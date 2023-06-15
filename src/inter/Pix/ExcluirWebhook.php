<?php

namespace Inter\Pix;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class ExcluirWebhook
{
    private $msg = "Chamada Iniciada - Excluir Webhook Pix";
    private $errorCallApiMessage = "Erro ao Excluir Webhook do Pix. ";

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
     * @throws ClientException
     * @throws ServerException
     */
    final public function call(string $chave): void
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK . CHAVE . $chave);

        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_PIX);
        $path = ConfigUtils::getPath(API_TYPE_PIX, API_ENDPOINT_PATH_DELETE_WEBHOOK);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE] . $chave;

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);
    }

}