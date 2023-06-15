<?php

namespace Inter\Pix;

use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Model\CobrancaBody;
use Inter\Model\Devolucao;
use Inter\Model\FiltrosCobrancaImediata;
use Inter\Model\FiltrosPixRecebidos;
use Inter\Model\Paginacao;
use Inter\Utils\TokenUtils;
use stdClass;

class PixSDK
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
     * Método para consultar uma cobrança através de um determinado txid.<p>
     *
     * @param string $txid - Obrigatório - TxId. $txid = "mmqksjgrhvtzxm1vn9lnlxuf2zkke7rh551"<p>
     * @return stdClass cobranca<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function consultarCobrancaImediata(string $txid): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_COB_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaCobrancaImediata = new ConsultarCobrancaImediata($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaCobrancaImediata->call($txid);
    }

    /**
     * Método para consultar cobranças imediatas através de parâmetros como início, fim, cpf, cnpj e status.<p>
     *
     * @param bool $buscaPaginada Obrigatório - Indica se o retorno será um objeto paginado ou um array com todos os objetos encontrados. $buscaPaginada = true<p>
     * @param string $dataInicio - Obrigatório - Filtra os registros cuja data de criação seja maior ou igual que a data de início. $dataInicio = "2023-01-01T00:00:00Z"<p>
     * @param string $dataFim - Obrigatório - Filtra os registros cuja data de criação seja menor ou igual que a data de fim. $dataFim = "2023-01-02T00:00:00Z"<p>
     * @param Paginacao | null $paginacao - Opcional - Objeto de paginação <p>
     * @param FiltrosCobrancaImediata | null $filtros - Opcional - Objeto com os filtros <p>
     *
     * @return stdClass| array cobrancas<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function consultarListaCobrancasImediatas(bool                    $buscaPaginada, string $dataInicio, string $dataFim,
                                                           FiltrosCobrancaImediata $filtros = null, Paginacao $paginacao = null)
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_COB_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaListaCobrancasImediatas = new ConsultarListaCobrancasImediatas($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaListaCobrancasImediatas->consultarListaCobrancasImediatas($buscaPaginada, $dataInicio,
            $dataFim, $filtros, $paginacao);
    }

    /**
     * Método para consultar locations cadastradas.<p>
     *
     * @param bool $buscaPaginada Obrigatório - Indica se o retorno será um objeto paginado ou um array com todos os objetos encontrados. $buscaPaginada = true<p>
     * @param string $dataInicio - Obrigatório - Filtra os registros cuja data de criação seja maior ou igual que a data de início. $dataInicio = "2023-01-01T00:00:00Z"<p>
     * @param string $dataFim - Obrigatório - Filtra os registros cuja data de criação seja menor ou igual que a data de fim. $dataFim = "2023-01-02T00:00:00Z"<p>
     * @param bool | null $txIdPresente - Opcional - Filtra pelo txId. $txIdPresente = true<p>
     * @param string | null $tipoCob - Opcional - Filtra pelo tipo de COB.<p>
     * Valores:<p>
     * . cob<p>
     * . cobv
     * @param Paginacao | null $paginacao - Opcional - Objeto de paginação <p>
     *
     * @return stdClass| array locations<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function consultarLocationsCadastradas(bool      $buscaPaginada, string $dataInicio, string $dataFim,
                                                        bool      $txIdPresente = null, string $tipoCob = null,
                                                        Paginacao $paginacao = null)
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAYLOAD_LOCATION_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaLocationsCadastradas = new ConsultarLocationsCadastradas($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaLocationsCadastradas->consultarLocationsCadastradas($buscaPaginada, $dataInicio, $dataFim,
            $txIdPresente, $tipoCob, $paginacao);
    }

    /**
     * Método para recuperar a location do payload.<p>
     *
     * @param string $id - Obrigatório - Id. $id = "134689"<p>
     * @return stdClass location<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function recuperarLocationDoPayload(string $id): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAYLOAD_LOCATION_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $recuperaLocationDoPayload = new RecuperarLocationDoPayload($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $recuperaLocationDoPayload->call($id);
    }

    /**
     * Método para consultar um pix através de um determinado EndToEndId.<p>
     *
     * @param string $e2eId - Obrigatório - Id único para identificação do pagamento Pix. $e2eId = "E0041696820230104484287u53vVeA6ZC"<p>
     * @return stdClass pix<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function consultarPix(string $e2eId): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PIX_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaPix = new ConsultarPix($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaPix->call($e2eId);
    }

    /**
     * Método para consultar um pix por um período específico, de acordo com os parâmetros informados.<p>
     *
     * @param bool $buscaPaginada Obrigatório - Indica se o retorno será um objeto paginado ou um array com todos os objetos encontrados. $buscaPaginada = true<p>
     * @param string $dataInicio - Obrigatório - Filtra os registros cuja data de criação seja maior ou igual que a data de início. $dataInicio = "2023-01-01T00:00:00Z"<p>
     * @param string $dataFim - Obrigatório - Filtra os registros cuja data de criação seja menor ou igual que a data de fim. $dataFim = "2023-01-02T00:00:00Z"<p>
     * @param FiltrosPixRecebidos | null $filtros - Opcional - Objeto com Filtros
     * @param Paginacao | null $paginacao - Opcional - Objeto de paginação <p>
     *
     * @return stdClass| array pixRecebidos<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function consultarPixRecebidos(bool                $buscaPaginada, string $dataInicio, string $dataFim,
                                                FiltrosPixRecebidos $filtros = null, Paginacao $paginacao = null)
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PIX_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaPixRecebidos = new ConsultarPixRecebidos($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaPixRecebidos->consultarPixRecebidos($buscaPaginada, $dataInicio, $dataFim,
            $filtros, $paginacao);
    }

    /**
     * Método para consultar uma devolução através de um E2EID do Pix e do ID da devolução.<p>
     *
     * @param string $e2eId - Obrigatório - Id único para identificação do pagamento Pix. $e2eId = "E004169682023010419287u53vVeA6TV"
     * @param string $id - Obrigatório - Id gerado pelo cliente para representar unicamente uma devolução. $id = "040120231689"
     * @return stdClass devolucao<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function consultarDevolucao(string $e2eId, string $id): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PIX_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $consultaDevolucaoImediata = new ConsultarDevolucaoImediata($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $consultaDevolucaoImediata->call($e2eId, $id);
    }

    /**
     * Método que obtém o webhook cadastrado, caso exista.<p>
     *
     * @param string $chave - Obrigatório - O campo chave determina a chave Pix do recebedor que foi utilizada para as cobranças.<p>
     * Os tipos de chave podem ser: telefone, e-mail, cpf/cnpj ou EVP.<p>
     * O formato das chaves pode ser encontrado na seção "Formatação das chaves do DICT no BR Code" do Manual de Padrões para iniciação do Pix. <p>
     * Consulte: https://www.bcb.gov.br/estabilidadefinanceira/pix<p>
     * @return stdClass webhook<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function obterWebhookCadastrado(string $chave): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_WEBHOOK_READ,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $obtemWebhookCadastrado = new ObterWebhookCadastrado($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $obtemWebhookCadastrado->call($chave);
    }

    /**
     * Método que exclui o webhook cadastrado, caso exista.<p>
     *
     * @param string $chave - Obrigatório - O campo chave determina a chave Pix do recebedor que foi utilizada para as cobranças.<p>
     * Os tipos de chave podem ser: telefone, e-mail, cpf/cnpj ou EVP.<p>
     * O formato das chaves pode ser encontrado na seção "Formatação das chaves do DICT no BR Code" do Manual de Padrões para iniciação do Pix. <p>
     * Consulte: https://www.bcb.gov.br/estabilidadefinanceira/pix<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function excluirWebhook(string $chave): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_WEBHOOK_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $excluiWebhook = new ExcluirWebhook($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $excluiWebhook->call($chave);
    }

    /**
     * Método destinado a criar um webhook para receber notificações de cobranças Pix recebidas<p>
     *
     * @param string $webhookUrl - Obrigatório - URL de configuração do webhook. $webhookUrl = "https://webhook.site/b166ebb1-d9ed-4215-82b8-147828761cf6"
     * @param string $chave - Obrigatório - O campo chave determina a chave Pix do recebedor que foi utilizada para as cobranças.<p>
     * Os tipos de chave podem ser: telefone, e-mail, cpf/cnpj ou EVP.<p>
     * O formato das chaves pode ser encontrado na seção "Formatação das chaves do DICT no BR Code" do Manual de Padrões para iniciação do Pix. <p>
     * Consulte: https://www.bcb.gov.br/estabilidadefinanceira/pix<p>
     *
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function criarWebhook(string $webhookUrl, string $chave): void
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_WEBHOOK_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $criaWebhook = new CriarWebhook($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        $criaWebhook->call($webhookUrl, $chave);
    }

    /**
     * Método para criar uma cobrança imediata.
     *
     * @param CobrancaBody $body Obrigatório <p>
     *
     * @return stdClass cobranca<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function criarCobrancaImediata(CobrancaBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_COB_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $criaCobrancaImediata = new CriarCobrancaImediata($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $criaCobrancaImediata->call($body);
    }

    /**
     * Método para criar uma cobrança imediata com txId.
     *
     * @param CobrancaBody $body - Obrigatório <p>
     * @param string $txId - Obrigatório - txId. $txId = "mmqksjgrhvtzxm1vn9lnlxuf2zkke7rh551" <p>
     *
     * @return stdClass cobranca<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function criarCobrancaImediataTxId(string $txId, CobrancaBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_COB_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $criaCobrancaImediataTxId = new CriarCobrancaImediataTxId($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $criaCobrancaImediataTxId->callCobrancaBody($body, $txId);
    }

    /**
     * Método para revisar uma cobrança imediata.
     *
     * @param CobrancaBody $body - Obrigatório <p>
     * @param string $txId - Obrigatório - txId. $txId = "mmqksjgrhvtzxm1vn9lnlxuf2zkke7rh551" <p>
     *
     * @return stdClass cobranca<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function revisarCobrancaImediata(string $txId, CobrancaBody $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_COB_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $revisaCobrancaImediata = new RevisarCobrancaImediata($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $revisaCobrancaImediata->call($body, $txId);
    }

    /**
     * Método para criar location do payload.
     *
     * @param string $tipoCob - Obrigatório - Valores:  <p>
     * . cob<p>
     * . cobv
     *
     * @return stdClass location<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function criarLocationDoPayload(string $tipoCob): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAYLOAD_LOCATION_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $criaLocationDoPayload = new CriarLocationDoPayload($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $criaLocationDoPayload->call($tipoCob);
    }

    /**
     * Método utilizado para desvincular uma cobrança de uma location.
     *
     * Se executado com sucesso, a entidade loc não apresentará mais um txid, <p>
     * se apresentava anteriormente à chamada. Adicionalmente, a entidade cob ou cobv associada ao <p>
     * txid desvinculado também passará a não mais apresentar um location. Esta operação<p>
     * não altera o status da cob ou cobv em questão.
     *
     * @param string $id - Obrigatório - ID  <p>
     *
     * @return stdClass location<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function desvincularCobrancaLocation(string $id): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PAYLOAD_LOCATION_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $desvinculaCobrancaLocation = new DesvincularConbrancaLocation($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $desvinculaCobrancaLocation->call($id);
    }

    /**
     * Método para solicitar uma devolução através de um E2EID do Pix e do ID da devolução.
     *
     * @param Devolucao $body - Obrigatório <p>
     * @param string $e2eId - Obrigatório - Id único para identificação do pagamento Pix. $e2eId = "E004169682023010419287u53vVeA6TV" <p>
     * @param string $id - Obrigatório - Id gerado pelo cliente para representar unicamente uma devolução.<p>
     * $id = "040120231689" <p>
     *
     * @return stdClass devolucao<p>
     * @throws ServerException<p>
     *
     * @throws ClientException
     */
    final public function solicitarDevolucao(string $e2eId, string $id, Devolucao $body): stdClass
    {
        $token = TokenUtils::buscaToken($this->clientSecret, $this->clientId, SCOPE_PIX_WRITE,
            $this->certificado, $this->senha, $this->ambiente, $this->contaCorrente, $this->debug,
            $this->controleRateLimit);

        $solicitaDevolucao = new SolicitarDevolucao($this->certificado, $this->senha, $token,
            $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);

        return $solicitaDevolucao->call($e2eId, $id, $body);
    }

}