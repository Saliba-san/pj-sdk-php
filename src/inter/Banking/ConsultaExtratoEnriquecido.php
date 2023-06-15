<?php

namespace Inter\Banking;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class ConsultaExtratoEnriquecido
{
    private $paginaQuery = "&pagina=";
    private $tamanhoPaginaQuery = "&tamanhoPagina=";
    private $tipoOperacaoQuery = "&tipoOperacao=";
    private $tipoTransacaoQuery = "&tipoTransacao=";
    private $msg = "Chamada Iniciada - Busca Extrato Enriquecido";
    private $errorCallApiMessage = "Erro na Consulta do Extrato Enriquecido. ";

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
    final public function buscaExtrato(string $dataInicio, string $dataFim, bool $buscaPaginada = true, int $pagina = null,
                                       int    $tamanhoPagina = null, string $tipoOperacao = null, string $tipoTransacao = null)
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg(PARAMETROS . LINE_BREAK .
            DATA_INICIO . $dataInicio . LINE_BREAK .
            DATA_FIM . $dataFim . LINE_BREAK .
            BUSCA_PAGINADA . var_export($buscaPaginada, true) . LINE_BREAK .
            PAGINA . $pagina . LINE_BREAK .
            TAMANHO_PAGINA . $tamanhoPagina . LINE_BREAK .
            TIPO_OPERACAO . $tipoOperacao . LINE_BREAK .
            TIPO_TRANSACAO . $tipoTransacao);

        if ($buscaPaginada) {
            $http_response = $this->call($dataInicio, $dataFim, $pagina, $tamanhoPagina,
                $tipoOperacao, $tipoTransacao);
            return json_decode($http_response->getBody(), false);
        }

        $continue = true;
        $page = 0;
        $tamanho = 10000;
        $trasancoes = [];

        while ($continue) {
            $http_response = $this->call($dataInicio, $dataFim, $page, $tamanho, $tipoOperacao, $tipoTransacao);

            $body = json_decode($http_response->getBody(), false);

            $trasancoes = array_merge((array)$trasancoes, (array)$body->transacoes);

            if ($body->ultimaPagina || $body->totalPaginas == 0) {
                $continue = false;
            }
            ++$page;
        }

        return $trasancoes;
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    private function call(string $dataInicio, string $dataFim, int $pagina = null, int $tamanhoPagina = null,
                          string $tipoOperacao = null, string $tipoTransacao = null): object
    {
        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_BANKING);
        $path = ConfigUtils::getPath(API_TYPE_BANKING, API_ENDPOINT_PATH_EXTRATO_ENRIQUECIDO);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $URL .= DATA_INICIO_QUERY . $dataInicio . DATA_FIM_QUERY . $dataFim;

        $this->buildQuery($URL, $pagina, $tamanhoPagina, $tipoOperacao, $tipoTransacao);

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);

        return $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);
    }

    private function buildQuery(string &$URL, int $pagina = null, int $tamanhoPagina = null,
                                string $tipoOperacao = null, string $tipoTransacao = null): void
    {
        if ($pagina !== null) {
            $URL .= $this->paginaQuery . $pagina;
        }

        if ($tamanhoPagina !== null) {
            $URL .= $this->tamanhoPaginaQuery . $tamanhoPagina;
        }

        if ($tipoOperacao !== null) {
            $URL .= $this->tipoOperacaoQuery . $tipoOperacao;
        }

        if ($tipoTransacao !== null) {
            $URL .= $this->tipoTransacaoQuery . $tipoTransacao;
        }
    }

}