<?php

namespace Inter\Cobranca;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\FiltrosColecaoBoletos;
use Inter\Model\Ordenacao;
use Inter\Model\Paginacao;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class RecuperarColecaoDeBoletos
{
    private $filtrarDataPorQuery = "&filtrarDataPor=";
    private $nossoNumeroQuery = "&nossoNumero=";
    private $nomeQuery = "&nome=";
    private $emailQuery = "&email=";
    private $cpfCnpjQuery = "&cpfCnpj=";
    private $situacaoQuery = "&situacao=";
    private $itensPorPaginaQuery = "&itensPorPagina=";
    private $paginaAtualQuery = "&paginaAtual=";
    private $tipoOrdenacaoQuery = "&tipoOrdenacao=";
    private $ordenarPorQuery = "&ordenarPor=";
    private $msg = "Chamada Iniciada - Recupera Coleção de Boletos";
    private $errorCallApiMessage = "Erro ao Recuperar Coleção de Boletos. ";

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
     * @throws ServerException
     */
    final public function recuperarColecaoDeBoletos(string                $dataInicio, string $dataFim, bool $buscaPaginada = true,
                                                    FiltrosColecaoBoletos $filtros = null,
                                                    Paginacao             $paginacao = null, Ordenacao $ordenacao = null)
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg($this->buildMsg($dataInicio, $dataFim, $buscaPaginada, $filtros, $paginacao, $ordenacao));

        if ($buscaPaginada) {
            $http_response = $this->call($dataInicio, $dataFim, $filtros, $paginacao, $ordenacao);
            return json_decode($http_response->getBody(), false);
        }

        $continue = true;
        $page = new Paginacao(0, 1000);
        $boletos = [];

        while ($continue) {
            $http_response = $this->call($dataInicio, $dataFim, $filtros, $page, $ordenacao);

            $body = json_decode($http_response->getBody(), false);

            $boletos = array_merge((array)$boletos, (array)$body->content);

            if ($body->last || ($body->totalPages - 1) == $page->getPaginaAtual()) {
                $continue = false;
            }
            $page->setPaginaAtual($page->getPaginaAtual() + 1);
        }

        return $boletos;
    }

    /**
     * @throws ClientException|ServerException
     */
    private function call(string    $dataInicio, string $dataFim, FiltrosColecaoBoletos $filtros = null,
                          Paginacao $paginacao = null, Ordenacao $ordenacao = null): object
    {
        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha,
            null, null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_COBRANCA);
        $path = ConfigUtils::getPath(API_TYPE_COBRANCA, API_ENDPOINT_PATH_RECUPERAR_COLECAO_BOLETOS);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $URL .= DATA_INICIO_QUERY_COBRANCA . $dataInicio . DATA_FIM_QUERY_COBRANCA . $dataFim;

        $this->buildQuery($URL, $filtros, $paginacao, $ordenacao);

        return (new CallAPI($configurations, $this->debug, $this->controleRateLimit))
            ->call($METHOD, $URL, $options, $this->errorCallApiMessage);
    }

    private function buildQuery(&$URL, FiltrosColecaoBoletos $filtros = null, Paginacao $paginacao = null, Ordenacao $ordenacao = null): void
    {

        if ($filtros !== null) {
            $this->buildQueryFiltros($URL, $filtros);
        }

        if ($paginacao !== null) {

            if ($paginacao->getItensPorPagina() !== null) {
                $URL .= $this->itensPorPaginaQuery . $paginacao->getItensPorPagina();
            }

            if ($paginacao->getPaginaAtual() !== null) {
                $URL .= $this->paginaAtualQuery . $paginacao->getPaginaAtual();
            }
        }

        if ($ordenacao !== null) {

            if ($ordenacao->getTipoOrdenacao() !== null) {
                $URL .= $this->tipoOrdenacaoQuery . $ordenacao->getTipoOrdenacao();
            }

            if ($ordenacao->getOrdenarPor() !== null) {
                $URL .= $this->ordenarPorQuery . $ordenacao->getOrdenarPor();
            }
        }
    }

    private function buildQueryFiltros(&$URL, FiltrosColecaoBoletos $filtros): void
    {
        if ($filtros->getSituacao() !== null) {
            $URL .= $this->situacaoQuery . $filtros->getSituacao();
        }

        if ($filtros->getNossoNumero() !== null) {
            $URL .= $this->nossoNumeroQuery . $filtros->getNossoNumero();
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

    final private function buildMsg(string $dataInicio, string $dataFim, bool $buscaPaginada, FiltrosColecaoBoletos $filtros = null, Paginacao $paginacao = null, Ordenacao $ordenacao = null): string
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

        if ($ordenacao !== null) {
            $mensagem .= LINE_BREAK .
                ORDENAR_POR . $ordenacao->getOrdenarPor() . LINE_BREAK .
                TIPO_ORDENACAO . $ordenacao->getTipoOrdenacao();
        }

        if ($filtros !== null) {
            $mensagem .= LINE_BREAK .
                CPF_CNPJ . $filtros->getCpfCnpj() . LINE_BREAK .
                EMAIL . $filtros->getEmail() . LINE_BREAK .
                FILTRA_DATA_POR . $filtros->getFiltrarDataPor() . LINE_BREAK .
                NOME . $filtros->getNome() . LINE_BREAK .
                NOSSO_NUMERO . $filtros->getNossoNumero() . LINE_BREAK .
                SITUACAO . $filtros->getSituacao();
        }

        return $mensagem;
    }

}