<?php

namespace Inter\Pix;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use stdClass;

class CriarLocationDoPayload
{
    private $msg = "Chamada Iniciada - Criar Location Do Payload";
    private $errorCallApiMessage = "Erro ao Criar Location Do Payload. ";
    private $content_type = 'application/json';
    private $body_parameter = 'tipoCob';

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
    final public function call(string $tipoCob): stdClass
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK . TIPO_COB . $tipoCob);

        $configurations = HttpUtils::getConfigurations();
        $bodyRequest = $this->getBody($tipoCob, $this->debug);
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, $bodyRequest,
            $this->content_type, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_PIX);
        $path = ConfigUtils::getPath(API_TYPE_PIX, API_ENDPOINT_PATH_CRIAR_LOCATION);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }

    final public function getBody(string $tipoCob, bool $debug = false): string
    {
        $body = json_encode([
            $this->body_parameter => $tipoCob
        ]);

        if ($debug) {
            LogUtils::logMsg(REQUEST_BODY . $body . LINE_BREAK);
        }

        return $body;
    }


}
