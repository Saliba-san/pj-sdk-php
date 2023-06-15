<?php

namespace Inter\Pix;

use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\FiltrosCobrancaImediata;
use Inter\Model\Paginacao;
use Inter\Utils\ConfigUtils;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;

class ConsultarListaCobrancasImediatas
{
    private $statusQuery = "&status=";
    private $cpfQuery = "&cpf=";
    private $cnpjQuery = "&cnpj=";
    private $locationPresenteQuery = "&locationPresente=";
    private $paginaAtualQuery = "&paginacao.paginaAtual=";
    private $itensPorPaginaQuery = "&paginacao.itensPorPagina=";
    private $msg = "Chamada Iniciada - Consulta Lista de Cobranças Imediatas";
    private $errorCallApiMessage = "Erro ao Consultar Lista de Cobranças Imediatas. ";

    private $certificado;
    private $senha;
    private $token;
    private $ambiente;
    private $debug;
    private $controleRateLimit;
    private $contaCorrente;

    public function __construct(string $certificado, string $senha, string $token, string $ambiente,
                                string $contaCorrente = null, bool   $debug = false,
                                bool $controleRateLimit = true)
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
    final public function consultarListaCobrancasImediatas(bool                    $buscaPaginada, string $dataInicio, string $dataFim,
                                                           FiltrosCobrancaImediata $filtros = null, Paginacao $paginacao = null)
    {
        LogUtils::logMsg($this->msg);
        LogUtils::logMsg($this->buildMsg($dataInicio, $dataFim, $buscaPaginada, $filtros, $paginacao));

        if ($buscaPaginada) {
            $http_response = $this->call($dataInicio, $dataFim, $filtros, $paginacao);
            return json_decode($http_response->getBody(), false);
        }

        $continue = true;
        $page = 0;
        $tamanho = 1000;
        $cobrancas = [];

        while ($continue) {

            $pag = new Paginacao($page, $tamanho);
            $http_response = $this->call($dataInicio, $dataFim, $filtros, $pag);

            $body = json_decode($http_response->getBody(), false);

            $cobrancas = array_merge((array)$cobrancas, (array)$body->cobs);

            if (($body->parametros->paginacao->quantidadeDePaginas - 1) == $body->parametros->paginacao->paginaAtual) {
                $continue = false;
            }
            ++$page;
        }

        return $cobrancas;
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    private function call(string    $dataInicio, string $dataFim, FiltrosCobrancaImediata $filtros = null,
                          Paginacao $paginacao = null): object
    {
        $configurations = HttpUtils::getConfigurations();
        $options = HttpUtils::getOptions($this->token, $this->certificado, $this->senha, null,
            null, $this->contaCorrente);

        $baseUrl = ConfigUtils::getBaseUrl($this->ambiente, API_TYPE_PIX);
        $path = ConfigUtils::getPath(API_TYPE_PIX, API_ENDPOINT_PATH_COBRANCAS_IMEDIATAS);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $URL .= INICIO_QUERY . $dataInicio . FIM_QUERY . $dataFim;

        $this->buildQuery($URL, $filtros, $paginacao);

        return (new CallAPI($configurations, $this->debug, $this->controleRateLimit))
            ->call($METHOD, $URL, $options, $this->errorCallApiMessage);
    }

    private function buildQuery(string    &$URL, FiltrosCobrancaImediata $filtros = null,
                                Paginacao $paginacao = null): void
    {
        if ($filtros !== null) {

            if ($filtros->getCpf() !== null) {
                $URL .= $this->cpfQuery . $filtros->getCpf();
            }

            if ($filtros->getCnpj() !== null) {
                $URL .= $this->cnpjQuery . $filtros->getCnpj();
            }

            if ($filtros->getLocationPresente() !== null) {
                $URL .= $this->locationPresenteQuery . var_export($filtros->getLocationPresente(), true);
            }

            if ($filtros->getStatus() !== null) {
                $URL .= $this->statusQuery . $filtros->getStatus();
            }

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

    final private function buildMsg(string                  $dataInicio, string $dataFim, bool $buscaPaginada,
                                    FiltrosCobrancaImediata $filtros = null, Paginacao $paginacao = null): string
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

        if ($filtros !== null) {
            $mensagem .= LINE_BREAK .
                STATUS . $filtros->getStatus() . LINE_BREAK .
                CPF . $filtros->getCpf() . LINE_BREAK .
                CNPJ . $filtros->getCnpj() . LINE_BREAK .
                LOCATION_PRESENTE . var_export($filtros->getLocationPresente(), true);
        }

        return $mensagem;
    }

}