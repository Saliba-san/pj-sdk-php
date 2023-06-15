<?php

namespace Inter\Banking;

use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\IncluirPagamentoBody;
use Inter\Model\IncluirPagamentoDarfBody;
use Inter\Model\IncluirPagamentoLoteBody;
use Inter\Model\IncluirPixBody;
use Inter\Model\IncluirTedBody;
use Inter\Utils\TokenUtils;
use stdClass;

class BankingSDK
{
    private $clientId;
    private $clientSecret;
    private $certificado;
    private $senha;
    private $ambiente;

    private $debug;
    private $controleRateLimit;
    private $contaCorrente;

    public function __construct(string $clientId, string $clientSecret, string $certificado,
                                string $senha, string $ambiente = "hml", string $contaCorrente = null,
                                bool   $debug = false, bool $controleRateLimit = true)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->certificado = $certificado;
        $this->senha = $senha;
        $this->ambiente = $ambiente;
        $this->debug = $debug;
        $this->controleRateLimit = $controleRateLimit;
        $this->contaCorrente = $contaCorrente;
    }

    public function setControleRateLimit(bool $controleRateLimit)
    {
        $this->controleRateLimit = $controleRateLimit;
    }

    public function setDebug(bool $debug)
    {
        $this->debug = $debug;
    }

    public function setContaCorrente(string $contaCorrente)
    {
        $this->contaCorrente = $contaCorrente;
    }

    public function setAmbiente(string $ambiente)
    {
        $this->ambiente = $ambiente;
    }

    /**
     * Método utilizado para consultar o saldo por um período específico.<p>
     *<p>
     * @param string|null $date Opcional - Data de consulta para o saldo posicional. $date = "2021-01-02"<p>
     * @return stdClass saldo<p>
     *<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function consultarSaldo(string $date = null): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_EXTRATO_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $buscaSaldo = new BuscaSaldo($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $buscaSaldo->call($date);
    }

    /**
     * Método utilizado para consultar o extrato por um período específico. O período máximo entre as datas é de 90 dias.
     *
     * @param string $dataInicio Obrigatório - Data início da consulta de extrato. $dataInicio = "2021-01-02"<p>
     * @param string $dataFim Obrigatório - Data fim da consulta de extrato. $dataFim = "2021-01-10"<p>
     * @return stdClass extrato<p>
     *<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function consultarExtrato(string $dataInicio, string $dataFim): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_EXTRATO_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaExtrato = new ConsultarExtrato($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaExtrato->call($dataInicio, $dataFim);
    }

    /**
     * Método utilizado para consultar extrato enriquecido com informações detalhadas de cada transação dado um período específico.<p>
     * O período máximo entre as datas é de 90 dias.<p>
     *<p>
     * @param bool $buscaPaginada Obrigatório - Indica se o retorno será um objeto paginado ou um array com todos os objetos encontrados. $buscaPaginada = true<p>
     * @param string $dataInicio Obrigatório - Data início da exportação de extrato. $dataInicio = "2021-01-02"<p>
     * @param string $dataFim Obrigatório - Data fim da exportação de extrato. $dataFim = "2021-01-10"<p>
     * @param string|null $tipoOperacao Opcional - Filtro sobre o tipo de operação.<p>
     * Valores: <br>
     * . D - Débito(Saída)<br>
     * . C - Crédito(Entrada)<br>
     * @param string|null $tipoTransacao Opcional - Filtro de transação vinculada a movimentacao.<p>
     * Valores:<br>
     * PIX, CAMBIO, ESTORNO, INVESTIMENTO, TRANSFERENCIA, PAGAMENTO, BOLETO_COBRANCA, OUTROS<br>
     * @param int|null $pagina Opcional - Posição da página na lista de movimentações.<br>
     * Esse campo é ignorado quando $buscaPaginada é falso. $pagina = 1<p>
     * @param int|null $tamanhoPagina Opcional - Tamanho da página na lista de movimentações por dia.<br>
     * Esse campo é ignorado quando $buscaPaginada é falso. $tamanhoPagina = 10<p>
     * @return stdClass | array extratoEnriquecido<p>
     * <p>
     * @throws ClientException
     * @throws ServerException <p>
     *<p>
     */
    final public function consultarExtratoEnriquecido(bool   $buscaPaginada, string $dataInicio, string $dataFim, string $tipoOperacao = null,
                                                      string $tipoTransacao = null, int $pagina = null, int $tamanhoPagina = null)
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_EXTRATO_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaExtratoEnriquecido = new ConsultaExtratoEnriquecido($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaExtratoEnriquecido->buscaExtrato($dataInicio, $dataFim, $buscaPaginada, $pagina, $tamanhoPagina, $tipoOperacao, $tipoTransacao);
    }

    /**
     * Método utilizado para recuperar o extrato em pdf por um período específico.<p>
     * Salva o arquivo .pdf no path especificado.<p>
     * O período máximo entre as datas é de 90 dias.<p>
     *
     * @param string $dataInicio Obrigatório - Data inicio da exportação de extrato. $dataInicio = "2021-01-02"<p>
     * @param string $dataFim Obrigatório - Data fim da exportação de extrato. $dataFim = "2021-01-10"<p>
     * @param string $path Obrigatório - Path onde o arquivo deverá ser salvo. $path = "../../extrato.pdf"<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function recuperarExtratoPDF(string $dataInicio, string $dataFim, string $path): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_EXTRATO_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $recuperaExtratoPDF = new ConsultarExtratoPdf($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $recuperaExtratoPDF->call($dataInicio, $dataFim, $path);
    }

    /**
     * Método responsável por buscar informações de pagamentos de boleto. <p>
     * Período máximo entre as datas inicio e fim é de 90 dias.<p>
     * Caso data inicio e fim seja nula, por default será consultado os últimos 30 dias por data de inclusão.
     *<p>
     * @param string $dataInicio Obrigatório - Data inicio, em acordo com o campo "filtrarDataPor". $dataInicio = "2022-08-11"<p>
     * @param string $dataFim Obrigatório - Data Fim, em acordo com o campo "filtrarDataPor". $dataFim = "2022-08-12"<p>
     * @param string|null $codBarraLinhaDigitavel Opcional - Código de barras ou Linha digitável do boleto. $codBarraLinhaDigitavel = "6.539000353864661e+46"<p>
     * <p>
     * @param string|null $codigoTransacao Opcional - Código de transação UUID. $codigoTransacao = "a928f403-0076-419b-9c99-432d52083d0a"<p>
     * @param string|null $filtrarDataPor Opcional - Os filtros de data inicial e data final se aplicarão a:<p>
     * Valores: <br>
     * . INCLUSAO - Data da operação que foi solicitado o pagamento do título. (Default)<p>
     * . PAGAMENTO - Data em que foi efetuado o pagamento do título.<p>
     * . VENCIMENTO - Data do vencimento do título de pagamento.<p>
     * @return array pagamentos<p>
     * <p>
     * @throws ClientException
     * @throws ServerException <p>
     *<p>
     */
    final public function buscarPagamentos(string $dataInicio, string $dataFim, string $codBarraLinhaDigitavel = null,
                                           string $codigoTransacao = null, string $filtrarDataPor = null): array
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $buscaPagamentos = new BuscaPagamentos($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $buscaPagamentos->call($dataInicio, $dataFim, $codBarraLinhaDigitavel,
            $codigoTransacao, $filtrarDataPor);
    }

    /**
     * Método para obter informações de pagamento de DARF. <p>
     * Período máximo entre as datas inicio e fim é de 90 dias.<p>
     * Caso data inicio e fim seja nula, por default será consultado os últimos 30 dias por data de inclusão.
     *<p>
     * @param string $dataInicio Obrigatório - Data inicio, em acordo com o campo "filtrarDataPor". $dataInicio = "2022-08-11"<p>
     * @param string $dataFim Obrigatório - Data Fim, em acordo com o campo "filtrarDataPor". $dataFim = "2022-08-12"<p>
     * @param string|null $codigoReceita Opcional - Código da receita. $codigoReceita = "211"<p>
     * <p>
     * @param string|null $codigoTransacao Opcional - Código de transação UUID. $codigoTransacao = "a928f403-0076-419b-9c99-432d52083d0a"<p>
     * @param string|null $filtrarDataPor Opcional - Os filtros de data inicial e data final se aplicarão a:<p>
     * Valores: <br>
     * . INCLUSAO - Data da operação que foi solicitado o pagamento do título. (Default)<p>
     * . PAGAMENTO - Data em que foi efetuado o pagamento do título.<p>
     * . VENCIMENTO - Data do vencimento do título de pagamento.<p>
     * . PERIODO_APURACAO - Filtro de data de período de apuração do pagamento da DARF.<p>
     * @return array pagamentosDarf<p>
     * <p>
     * @throws ClientException
     * @throws ServerException <p>
     *<p>
     */
    final public function buscarPagamentosDarf(string $dataInicio, string $dataFim, string $codigoReceita = null,
                                               string $codigoTransacao = null, string $filtrarDataPor = null): array
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $buscaPagamentosDarf = new BuscaPagamentosDarf($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $buscaPagamentosDarf->call($dataInicio, $dataFim, $codigoReceita, $codigoTransacao, $filtrarDataPor);
    }

    /**
     * Método para obter informações de pagamentos de lote.
     *
     * @param string $idLote Obrigatório - Id do lote. $idLote = "6402546f8b3e1600943208dc"<p>
     * @return stdClass lote<p>
     *<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function buscarLotePagamentos(string $idLote): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAGAMENTO_LOTE_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $buscaLotePagamentos = new BuscarLotePagamentos($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $buscaLotePagamentos->call($idLote);
    }

    /**
     * Método que obtém o webhook cadastrado, caso exista.
     *
     * @param string $tipoWebhook Obrigatório - Tipo de webhook - $tipoWebhook = "pix-pagamento" <p>
     *
     * @return stdClass webHook<p>
     *<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function obterWebhookCadastrado(string $tipoWebhook): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_WEBHOOK_BANKING_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $obtemWebhookCadastrado = new ObterWebhookCadastrado($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $obtemWebhookCadastrado->call($tipoWebhook);
    }

    /**
     * Método que exclui o webhook.
     *
     * @param string $tipoWebhook Obrigatório - Tipo de webhook - $tipoWebhook = "pix-pagamento" <p>
     *
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function excluirWebhook(string $tipoWebhook): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_WEBHOOK_BANKING_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $excluiWehhook = new ExcluirWebhook($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $excluiWehhook->call($tipoWebhook);
    }

    /**
     * Método destinado a criar um webhook para receber notificações de confirmação de envio de pix (callbacks).
     *
     * @param string $webhookUrl Obrigatório -  $webhookUrl = "https://webhook.site/b166ebb1-d9ed-4215-82b8-147828761cf6"<p>
     *<p>
     * @param string $tipoWebhook Obrigatório - Tipo de webhook - $tipoWebhook = "pix-pagamento" <p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function criarWebhook(string $webhookUrl, string $tipoWebhook): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_WEBHOOK_BANKING_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $criaWehhook = new CriarWebhook($this->certificado, $this->senha, $token, $this->ambiente,
            $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $criaWehhook->call($webhookUrl, $tipoWebhook);
    }

    /**
     * Método para inclusão de um pagamento imediato ou agendamento do pagamento de boleto, convênio ou tributo com código de barras.
     *
     * @param IncluirPagamentoBody $body Obrigatório <p>
     *<p>
     * @return stdClass pagamento<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function incluirPagamentoComCodigoDeBarras(IncluirPagamentoBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $incluiPagamentoComCodigoDeBarras = new IncluirPagamentoCodigoBarras($this->certificado, $this->senha,
            $token, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $incluiPagamentoComCodigoDeBarras->call($body);
    }

    /**
     * Método para inclusão de um pagamento imediato de DARF sem código de barras.
     *
     * @param IncluirPagamentoDarfBody $body Obrigatório <p>
     *<p>
     * @return stdClass pagamento<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function incluirPagamentoDarf(IncluirPagamentoDarfBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAGAMENTO_DARF_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $incluiPagamentoDarf = new IncluirPagamentoDarf($this->certificado, $this->senha,
            $token, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $incluiPagamentoDarf->call($body);
    }

    /**
     * Método para inclusão de um lote de pagamentos digitados pelo cliente.
     *
     * @param IncluirPagamentoLoteBody $body Obrigatório <p>
     *<p>
     * @return stdClass pagamentos<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function incluirPagamentosEmLote(IncluirPagamentoLoteBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAGAMENTO_LOTE_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $incluiPagamentosEmLote = new IncluirPagamentosEmLote($this->certificado, $this->senha,
            $token, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $incluiPagamentosEmLote->call($body);
    }

    /**
     * Método para inclusão de um pagamento/transferência Pix utilizando dados bancários ou chave.
     *
     * @param IncluirPixBody $body Obrigatório <p>
     *<p>
     * @return stdClass pix<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function incluirPix(IncluirPixBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAGAMENTO_PIX_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $incluiPix = new IncluirPix($this->certificado, $this->senha,
            $token, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $incluiPix->call($body);
    }

    /**
     * Método para inclusão de um agendamento ou transferência imediata usando dados bancários.
     *
     * @param IncluirTedBody $body Obrigatório <p>
     *<p>
     * @return stdClass ted<p>
     * @throws ServerException<p>
     *<p>
     * @throws ClientException
     */
    final public function incluirTed(IncluirTedBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_TED_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $incluiTed = new IncluirTed($this->certificado, $this->senha,
            $token, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $incluiTed->call($body);
    }


}