<?php

namespace Inter\Cobranca;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\FiltrosCobranca;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use stdClass;

class RecuperarSumarioDeBoletos
{
    private $filtrarDataPorQuery = "&filtrarDataPor=";
    private $nomeQuery = "&nome=";
    private $emailQuery = "&email=";
    private $cpfCnpjQuery = "&cpfCnpj=";
    private $situacaoQuery = "&situacao=";
    private $msg = "Chamada Iniciada - Recupera Sumário de Boletos";
    private $errorCallApiMessage = "Erro ao Recuperar Sumario de Boletos. ";

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
    final public function recuperarSumarioDeBoletos(string          $dataInicio, string $dataFim,
                                                    FiltrosCobranca $filtros = null): stdClass
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg($this->buildMsg($dataInicio, $dataFim, $filtros));

        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_COBRANCA);
        $path = ConfigUtils::getPath(API_TYPE_COBRANCA, API_ENDPOINT_PATH_RECUPERAR_SUMARIO_BOLETOS);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $URL .= DATA_INICIO_QUERY_COBRANCA . $dataInicio . DATA_FIM_QUERY_COBRANCA . $dataFim;

        $this->buildQuery($URL, $filtros);

        $callApi = new CallAPI($configurations, $this->debug, $this->controleRateLimit);
        $http_response = $callApi->call($METHOD, $URL, $options, $this->errorCallApiMessage);

        return json_decode($http_response->getBody(), false);
    }


    private function buildQuery(&$URL, FiltrosCobranca $filtros = null): void
    {
        if ($filtros !== null) {
            $this->buildQueryFiltros($URL, $filtros);
        }

    }

    private function buildQueryFiltros(&$URL, FiltrosCobranca $filtros): void
    {
        if ($filtros->getSituacao() !== null) {
            $URL .= $this->situacaoQuery . $filtros->getSituacao();
        }

        if ($filtros->getNome() !== null) {
            $URL .= $this->nomeQuery . $filtros->getNome();
        }

        if ($filtros->getFiltrarDataPor() !== null) {
            $URL .= $this->filtrarDataPorQuery . $filtros->getFiltrarDataPor();
        }

        if ($filtros->getEmail() !== null) {
            $URL .= $this->emailQuery . $filtros->getEmail();
        }

        if ($filtros->getCpfCnpj() !== null) {
            $URL .= $this->cpfCnpjQuery . $filtros->getCpfCnpj();
        }
    }

    final private function buildMsg(string $dataInicio, string $dataFim, FiltrosCobranca $filtros = null): string
    {
        $mensagem = PARAMETROS . LINE_BREAK .
            DATA_INICIO . $dataInicio . LINE_BREAK .
            DATA_FIM . $dataFim;

        if ($filtros !== null) {
            $mensagem .= LINE_BREAK .
                CPF_CNPJ . $filtros->getCpfCnpj() . LINE_BREAK .
                EMAIL . $filtros->getEmail() . LINE_BREAK .
                FILTRA_DATA_POR . $filtros->getFiltrarDataPor() . LINE_BREAK .
                NOME . $filtros->getNome() . LINE_BREAK .
                SITUACAO . $filtros->getSituacao();
        }

        return $mensagem;
    }

}