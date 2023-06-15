<?php

namespace Inter\Banking;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class BuscaPagamentosDarf
{
    private $codigoTransacaoQuery = "&codigoTransacao=";
    private $filtrarDataPorQuery = "&filtrarDataPor=";
    private $codigoReceita = "&codigoReceita=";
    private $msg = "Chamada Iniciada - Busca Pagamentos de DARF";
    private $errorCallApiMessage = "Erro na Busca de Pagamentos DARF. ";

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
     */
    final public function call(string $dataInicio = null, string $dataFim = null, string $codigoReceita = null,
                               string $codigoTransacao = null, string $filtrarDataPor = null): array
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK .
            DATA_INICIO . $dataInicio . LINE_BREAK .
            DATA_FIM . $dataFim . LINE_BREAK .
            COD_RECEITA . $codigoReceita . LINE_BREAK .
            COD_TRANSACAO . $codigoTransacao . LINE_BREAK .
            FILTRA_DATA_POR . $filtrarDataPor);

        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_BANKING);
        $path = ConfigUtils::getPath(API_TYPE_BANKING, API_ENDPOINT_PATH_PAGAMENTOS_DARF);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE] . DATA_INICIO_QUERY . $dataInicio . DATA_FIM_QUERY . $dataFim;

        $this->buildQuery($URL, $codigoReceita, $codigoTransacao, $filtrarDataPor);

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }

    private function buildQuery(string &$URL, string $codigoReceita = null,
                                string $codigoTransacao = null, string $filtrarDataPor = null): void
    {
        if ($codigoReceita !== null) {
            $URL .= $this->codigoReceita . $codigoReceita;
        }

        if ($codigoTransacao !== null) {
            $URL .= $this->codigoTransacaoQuery . $codigoTransacao;
        }

        if ($filtrarDataPor !== null) {
            $URL .= $this->filtrarDataPorQuery . $filtrarDataPor;
        }
    }

}