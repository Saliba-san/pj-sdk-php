<?php

namespace Inter\Cobranca;

use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\BoletoBody;
use Inter\Model\FiltrosCobranca;
use Inter\Model\FiltrosColecaoBoletos;
use Inter\Model\Ordenacao;
use Inter\Model\Paginacao;
use Inter\Pix\RecuperarBoletoDetalhado;
use Inter\Utils\TokenUtils;
use stdClass;

class CobrancaSDK
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
     * Método utilizado para recuperar uma coleção de Boletos por um período específico,<p>
     * de acordo com os parâmetros informados.<p>
     *
     * @param bool $buscaPaginada Obrigatório - Indica se o retorno será um objeto paginado ou um array com todos os objetos encontrados. $buscaPaginada = true<p>
     * @param string $dataInicio - Obrigatório - Filtra os registros cuja data de criação seja maior ou igual que a data de início. $dataInicio = "2023-01-01"<p>
     * @param string $dataFim - Obrigatório - Filtra os registros cuja data de criação seja menor ou igual que a data de fim. $dataFim = "2023-01-02"<p>
     * @param Paginacao | null $paginacao - Opcional - Objeto de paginação <p>
     * @param Ordenacao | null $ordenacao - Opcional - Objeto de ordenação <p>
     * @param FiltrosColecaoBoletos | null $filtros - Opcional - Objeto com os filtros <p>
     *
     * @return stdClass| array boletos<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function recuperarColecaoDeBoletos(bool      $buscaPaginada, string $dataInicio, string $dataFim,
                                                    Ordenacao $ordenacao = null, FiltrosColecaoBoletos $filtros = null,
                                                    Paginacao $paginacao = null)
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $recuperaColecaoDeBoletos = new RecuperarColecaoDeBoletos($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $recuperaColecaoDeBoletos->recuperarColecaoDeBoletos($dataInicio, $dataFim, $buscaPaginada,
            $filtros, $paginacao, $ordenacao);
    }

    /**
     * Método utilizado para recuperar o sumário de uma coleção de Boletos por um período<p>
     * específico, de acordo com os parâmetros informados.<p>
     *
     * @param string $dataInicio - Obrigatório - Filtra os registros cuja data de criação seja maior ou igual que a data de início. $dataInicio = "2023-01-01"<p>
     * @param string $dataFim - Obrigatório - Filtra os registros cuja data de criação seja menor ou igual que a data de fim. $dataFim = "2023-01-02"<p>
     * @param FiltrosCobranca | null $filtros - Opcional - Objeto com os filtros <p>
     *
     * @return stdClass sumario<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function recuperarSumarioDeBoletos(string          $dataInicio, string $dataFim,
                                                    FiltrosCobranca $filtros = null): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $recuperaSumarioDeBoletos = new RecuperarSumarioDeBoletos($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $recuperaSumarioDeBoletos->recuperarSumarioDeBoletos($dataInicio, $dataFim, $filtros);
    }

    /**
     * Método para recuperar um boleto detalhado de acordo com o parâmetro nossoNumero informado.<p>
     *
     * @param string $nossoNumero - Obrigatório - Nosso número associado ao boleto. $nossoNumero = "00783398490"<p>
     * @return stdClass boleto<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function recuperarBoletoDetalhado(string $nossoNumero): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $recuperaBoletoDetalhado = new RecuperarBoletoDetalhado($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $recuperaBoletoDetalhado->call($nossoNumero);
    }

    /**
     * Método para recuperar um boleto detalhado de acordo com o parâmetro nossoNumero informado.<p>
     *
     * @param string $nossoNumero - Obrigatório - Nosso número associado ao boleto. $nossoNumero = "00783398490"<p>
     * @param string $path - Obrigatório - Path em que o arquivo .pdf será salvo. $path = "arquivos/boleto.pdf"<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function recuperarBoletoEmPDF(string $nossoNumero, string $path): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $recuperaBoletoEmPDF = new RecuperarBoletoEmPdf($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $recuperaBoletoEmPDF->call($nossoNumero, $path);
    }

    /**
     * Método que obtém o webhook cadastrado, caso exista.<p>
     *
     * @return stdClass webhook<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function obterWebhookCadastrado(): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $obtemWebhookCadastrado = new ObterWebhookCadastrado($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $obtemWebhookCadastrado->call();
    }

    /**
     * Método para excluir webhook, caso exista<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function excluirWebhook(): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $excluiWebhook = new ExcluirWebhook($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $excluiWebhook->call();
    }

    /**
     * Método para criar webhook<p>
     *
     * @param string $webhookUrl - Obrigatório - URL de configuração do webhook. $webhookUrl = "https://webhook.site/b166ebb1-d9ed-4215-82b8-147828761cf6"
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function criarWebhook(string $webhookUrl): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente,
            $this->debug, $this->controleRateLimit);

        $criaWebhook = new CriarWebhook($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $criaWebhook->call($webhookUrl);
    }

    /**
     * Método utilizado para emitir um novo boleto registrado.<p>
     * O boleto emitido estará disponível para consulta e pagamento, após um tempo apróximado de 5 minutos<p>
     * da sua inclusão. Esse tempo é necessário para o registro do boleto na CIP.
     *
     * @param BoletoBody $body Obrigatório <p>
     *
     * @return stdClass cobranca<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function emitirBoletoDeCobranca(BoletoBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $emitiBoletoDeCobranca = new EmitirBoletoDeCobranca($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $emitiBoletoDeCobranca->call($body);
    }

    /**
     * Método que realiza o cancelamento de um boleto.<p>
     *
     * @param string $nossoNumero - Obrigatório - Realiza o cancelamento de um boleto. $nossoNumero = "123456"
     * @param string $motivoCancelamento - Obrigatório - Domínio que descreve o tipo de cancelamento sendo solicitado.<p>
     * Valores: <p>
     * . ACERTOS (cancelado por acertos) <p>
     * . APEDIDODOCLIENTE (cancelado a pedido do cliente) <p>
     * . DEVOLUCAO (cancelado por devolução) <p>
     * . PAGODIRETOAOCLIENTE (cancelado por ter sido pago direto ao cliente) <p>
     * . SUBSTITUICAO (cancelado por substituição)<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function cancelarBoleto(string $nossoNumero, string $motivoCancelamento): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_BOLETO_COBRANCA_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $cancelaBoleto = new CancelarBoleto($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $cancelaBoleto->call($nossoNumero, $motivoCancelamento);
    }


}