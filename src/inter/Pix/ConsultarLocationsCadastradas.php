<?php

namespace Inter\Pix;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\Paginacao;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class ConsultarLocationsCadastradas
{
    private $tipoCobQuery = "&tipoCob=";
    private $txIdPresenteQuery = "&txIdPresente=";
    private $paginaAtualQuery = "&paginacao.paginaAtual=";
    private $itensPorPaginaQuery = "&paginacao.itensPorPagina=";
    private $msg = "Chamada Iniciada - Consulta Locations Cadastradas";
    private $errorCallApiMessage = "Erro ao Consultar Locations Cadastradas. ";

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
    final public function consultarLocationsCadastradas(bool $buscaPaginada, string $dataInicio, string $dataFim,
                                                        bool $txIdPresente = null, string $tipoCob = null, Paginacao $paginacao = null)
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg($this->buildMsg($dataInicio, $dataFim, $buscaPaginada,
            $txIdPresente, $tipoCob, $paginacao));

        if ($buscaPaginada) {
            $http_response = $this->call($dataInicio, $dataFim, $txIdPresente, $tipoCob, $paginacao);
            return json_decode($http_response->getBody(), false, 512);
        }

        $continue = true;
        $page = 0;
        $tamanho = 1000;
        $locations = [];

        while ($continue) {

            $pag = new Paginacao($page, $tamanho);
            $http_response = $this->call($dataInicio, $dataFim, $txIdPresente, $tipoCob, $pag);

            $body = json_decode($http_response->getBody(), false, 512);

            $locations = array_merge((array)$locations, (array)$body->loc);

            if (($body->parametros->paginacao->quantidadeDePaginas - 1) == $body->parametros->paginacao->paginaAtual) {
                $continue = false;
            }
            ++$page;
        }

        return $locations;
    }

    /**
     * @throws ClientException|ServerException
     */
    private function call(string $dataInicio, string $dataFim, bool $txIdPresente = null,
                          string $tipoCob = null, Paginacao $paginacao = null): object
    {
        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_PIX);
        $path = ConfigUtils::getPath(API_TYPE_PIX, API_ENDPOINT_PATH_LOCATIONS_CADASTRADAS);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $URL .= INICIO_QUERY . $dataInicio . FIM_QUERY . $dataFim;

        $this->buildQuery($URL, $txIdPresente, $tipoCob, $paginacao);

        return (new CallAPI($configurations, $this->debug, $this->controleRateLimit))
            ->call($METHOD, $URL, $options, $this->errorCallApiMessage);
    }

    private function buildQuery(string    &$URL, bool $txIdPresente = null, string $tipoCob = null,
                                Paginacao $paginacao = null): void
    {
        if ($tipoCob !== null) {
            $URL .= $this->tipoCobQuery . $tipoCob;
        }

        if ($txIdPresente !== null) {
            $URL .= $this->txIdPresenteQuery . var_export($txIdPresente, true);
        }

        if ($paginacao !== null) {

            if ($paginacao->getItensPorPagina() !== null) {
                $URL .= $this->itensPorPaginaQuery . $paginacao->getItensPorPagina();
            }

            if ($paginacao->getPaginaAtual() !== null) {
                $URL .= $this->paginaAtualQuery . $paginacao->getPaginaAtual();
            }
        }
    }

    final private function buildMsg(string    $dataInicio, string $dataFim, bool $buscaPaginada,
                                    bool      $txIdPresente = null, string $tipoCob = null,
                                    Paginacao $paginacao = null): string
    {
        $mensagem = PARAMETROS . LINE_BREAK .
            DATA_INICIO . $dataInicio . LINE_BREAK .
            DATA_FIM . $dataFim . LINE_BREAK .
            BUSCA_PAGINADA . var_export($buscaPaginada, true);

        if ($paginacao !== null) {
            $mensagem .= LINE_BREAK .
                PAGINA_ATUAL . $paginacao->getPaginaAtual() . LINE_BREAK .
                ITENS_POR_PAGINA . $paginacao->getItensPorPagina();
        }

        $mensagem .= LINE_BREAK .
            TIPO_COB . $tipoCob . LINE_BREAK .
            TX_ID_PRESENTE . var_export($txIdPresente, true);


        return $mensagem;
    }

}