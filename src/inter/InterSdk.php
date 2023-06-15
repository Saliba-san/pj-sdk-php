<?php

namespace Inter;

include_once __DIR__ . '/Constants/Constants.php';
include_once __DIR__ . '/Utils/ConfigUtils.php';
include_once __DIR__ . '/Model/InstituicaoFinanceira.php';
include_once __DIR__ . '/Model/Violacao.php';
include_once __DIR__ . '/Model/Erro.php';
include_once __DIR__ . '/Model/Paginacao.php';
include_once __DIR__ . '/Model/FiltrosCobrancaImediata.php';
include_once __DIR__ . '/Model/FiltrosPixRecebidos.php';
include_once __DIR__ . '/Model/FiltrosCobranca.php';
include_once __DIR__ . '/Model/FiltrosColecaoBoletos.php';
include_once __DIR__ . '/Model/Ordenacao.php';
include_once __DIR__ . '/Model/Calendario.php';
include_once __DIR__ . '/Model/Devedor.php';
include_once __DIR__ . '/Model/Saque.php';
include_once __DIR__ . '/Model/Troco.php';
include_once __DIR__ . '/Model/Retirada.php';
include_once __DIR__ . '/Model/InfoAdicional.php';
include_once __DIR__ . '/Model/CobrancaBody.php';
include_once __DIR__ . '/Model/Loc.php';
include_once __DIR__ . '/Model/Valor.php';
include_once __DIR__ . '/Model/Devolucao.php';
include_once __DIR__ . '/Model/Desconto.php';
include_once __DIR__ . '/Model/Mensagem.php';
include_once __DIR__ . '/Model/Mora.php';
include_once __DIR__ . '/Model/Multa.php';
include_once __DIR__ . '/Model/Pessoa.php';
include_once __DIR__ . '/Model/BoletoBody.php';
include_once __DIR__ . '/Model/IncluirPagamentoBody.php';
include_once __DIR__ . '/Model/IncluirPagamentoDarfBody.php';
include_once __DIR__ . '/Model/IncluirPagamentoLoteBody.php';
include_once __DIR__ . '/Model/Chave.php';
include_once __DIR__ . '/Model/DadosBancarios.php';
include_once __DIR__ . '/Model/Favorecido.php';
include_once __DIR__ . '/Model/IncluirTedBody.php';
include_once __DIR__ . '/Model/IncluirPixBody.php';
include_once __DIR__ . '/CallAPI.php';
include_once __DIR__ . '/Utils/SslUtils.php';
include_once __DIR__ . '/Utils/TokenUtils.php';
include_once __DIR__ . '/Utils/HttpUtils.php';
include_once __DIR__ . '/Utils/LogUtils.php';
include_once __DIR__ . '/Banking/BuscaPagamentos.php';
include_once __DIR__ . '/Banking/BuscarLotePagamentos.php';
include_once __DIR__ . '/Banking/BuscaPagamentosDarf.php';
include_once __DIR__ . '/Banking/ConsultarExtrato.php';
include_once __DIR__ . '/Banking/ConsultaExtratoEnriquecido.php';
include_once __DIR__ . '/Banking/ObterWebhookCadastrado.php';
include_once __DIR__ . '/Banking/ConsultarExtratoPdf.php';
include_once __DIR__ . '/Banking/BuscaSaldo.php';
include_once __DIR__ . '/Banking/BuscaPagamentos.php';
include_once __DIR__ . '/Banking/ExcluirWebhook.php';
include_once __DIR__ . '/Banking/CriarWebhook.php';
include_once __DIR__ . '/Banking/IncluirPagamentoCodigoBarras.php';
include_once __DIR__ . '/Banking/IncluirPagamentoDarf.php';
include_once __DIR__ . '/Banking/IncluirPagamentosEmLote.php';
include_once __DIR__ . '/Banking/IncluirPix.php';
include_once __DIR__ . '/Banking/IncluirTed.php';
include_once __DIR__ . '/Banking/BankingSDK.php';
include_once __DIR__ . '/Pix/PixSDK.php';
include_once __DIR__ . '/Pix/ConsultarCobrancaImediata.php';
include_once __DIR__ . '/Pix/ConsultarListaCobrancasImediatas.php';
include_once __DIR__ . '/Pix/ConsultarLocationsCadastradas.php';
include_once __DIR__ . '/Pix/RecuperarLocationDoPayload.php';
include_once __DIR__ . '/Pix/ConsultarPix.php';
include_once __DIR__ . '/Pix/ConsultarDevolucaoImediata.php';
include_once __DIR__ . '/Pix/ConsultarPixRecebidos.php';
include_once __DIR__ . '/Pix/ObterWebhookCadastrado.php';
include_once __DIR__ . '/Pix/ExcluirWebhook.php';
include_once __DIR__ . '/Pix/CriarWebhook.php';
include_once __DIR__ . '/Pix/CriarCobrancaImediata.php';
include_once __DIR__ . '/Pix/CriarCobrancaImediataTxId.php';
include_once __DIR__ . '/Pix/RevisarCobrancaImediata.php';
include_once __DIR__ . '/Pix/CriarLocationDoPayload.php';
include_once __DIR__ . '/Pix/DesvincularConbrancaLocation.php';
include_once __DIR__ . '/Pix/SolicitarDevolucao.php';
include_once __DIR__ . '/Cobranca/CobrancaSDK.php';
include_once __DIR__ . '/Cobranca/RecuperarColecaoDeBoletos.php';
include_once __DIR__ . '/Cobranca/RecuperarBoletoDetalhado.php';
include_once __DIR__ . '/Cobranca/RecuperarSumarioDeBoletos.php';
include_once __DIR__ . '/Cobranca/RecuperarBoletoEmPdf.php';
include_once __DIR__ . '/Cobranca/ObterWebhookCadastrado.php';
include_once __DIR__ . '/Cobranca/ExcluirWebhook.php';
include_once __DIR__ . '/Cobranca/CriarWebhook.php';
include_once __DIR__ . '/Cobranca/EmitirBoletoDeCobranca.php';
include_once __DIR__ . '/Cobranca/CancelarBoleto.php';
include_once __DIR__ . '/Exception/SdkException.php';
include_once __DIR__ . '/Exception/ServerException.php';
include_once __DIR__ . '/Exception/ClientException.php';
include_once __DIR__ . '/Exception/CertificadoExpiradoException.php';
include_once __DIR__ . '/Exception/CertificadoNaoEncontrado.php';
include_once __DIR__ . '/Exception/ChaveNaoEncontradaException.php';
include_once __DIR__ . '/Exception/ErroLeituraCertificadoException.php';
include_once __DIR__ . '/Exception/ErroLeituraChaveCertificadoException.php';

use Inter\Banking\BankingSDK;
use Inter\Cobranca\CobrancaSDK;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Pix\PixSDK;
use Inter\Utils\LogUtils;
use Inter\Utils\SslUtils;

class InterSdk
{
    private $clientId;
    private $clientSecret;
    private $certificado;
    private $senha;

    private $ambiente;

    private $banking;
    private $pix;
    private $cobranca;

    private $mensagem = "Inter SDK iniciado - Ambiente: ";
    private $avisos = [];

    private $debug;
    private $controleRateLimit;
    private $contaCorrente;

    /**
     * Construtor de uma instância do SDK
     *
     * @param string $certificado Path do Certificado
     * @param string $senha Path da key do Certificado
     * @param string $clientId Client Id
     * @param string $clientSecret Client Secret
     *
     * @return InterSdk sdk
     *
     * @throws ErroLeituraChaveCertificadoException
     * @throws CertificadoNaoEncontrado
     * @throws ChaveNaoEncontradaException
     * @throws ErroLeituraCertificadoException
     * @throws CertificadoExpiradoException
     */
    public function __construct(string $clientId, string $clientSecret, string $certificado, string $senha)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->certificado = $certificado;
        $this->senha = $senha;
        $this->ambiente = "production";
        $this->debug = false;
        $this->controleRateLimit = true;

        LogUtils::verificaExistenciaDeArquivoDeLog();
        LogUtils::logMsg($this->mensagem . $this->ambiente);
        SslUtils::valida_certificado($this->certificado, $this->senha, $this->avisos);
    }

    /**
     * Retorna um objeto com todos os métodos disponíveis para chamadas na api do Banking
     *
     * * @return BankingSDK banking
     */
    final public function banking(): BankingSDK
    {
        if ($this->banking == null) {
            $this->banking = new BankingSdk($this->clientId, $this->clientSecret, $this->certificado,
                $this->senha, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);
        }

        return $this->banking;
    }

    /**
     * Retorna um objeto com todos os métodos disponíveis para chamadas na api do Pix
     *
     * * @return PixSDK pix
     */
    final public function pix(): PixSDK
    {
        if ($this->pix == null) {
            $this->pix = new PixSDK($this->clientId, $this->clientSecret, $this->certificado, $this->senha,
                $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);
        }

        return $this->pix;
    }

    /**
     * Retorna um objeto com todos os métodos disponíveis para chamadas na api da Cobrança
     *
     * * @return CobrancaSDK cobranca
     */
    final public function cobranca(): CobrancaSDK
    {
        if ($this->cobranca == null) {
            $this->cobranca = new CobrancaSDK($this->clientId, $this->clientSecret, $this->certificado,
                $this->senha, $this->ambiente, $this->contaCorrente, $this->debug, $this->controleRateLimit);
        }

        return $this->cobranca;
    }

    /**
     * Retorna um lista de strings com avisos que o SDK gera
     *
     * * @return array avisos
     */
    public function getAvisos(): array
    {
        return $this->avisos;
    }

    /**
     * Retorna o valor do campo debug do SDK
     *
     * @return bool $debug Campo opcional com default false. Quando true, o SDK grava nos arquivos de log
     * o body das requests feitas para a api e o body das respostas.
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Retorna o valor do campo $controleRateLimit do SDK. Campo opcional com default true.
     * Quando true o SDK gere automaticamente exeções do tipo 429.<br>
     * A thread é interrompida por 60 segundos e a chamada é refeita.
     *
     * * @return bool controleRateLimit
     */
    public function getControleRateLimit()
    {
        return $this->controleRateLimit;
    }

    /**
     * Altera o valor do campo controleRateLimit do SDK. Campo opcional com default true.
     * Quando true o SDK gere automaticamente exeções do tipo 429.<br>
     * A thread é interrompida por 60 segundos e a chamada é refeita.
     *
     * @param bool $controleRateLimit Novo valor do campo controleRateLimit
     *
     * * @return void
     */
    public function setControleRateLimit(bool $controleRateLimit)
    {
        $this->controleRateLimit = $controleRateLimit;

        if ($this->pix !== null) {
            $this->pix->setControleRateLimit($controleRateLimit);
        }

        if ($this->banking !== null) {
            $this->banking->setControleRateLimit($controleRateLimit);
        }

        if ($this->cobranca !== null) {
            $this->cobranca->setControleRateLimit($controleRateLimit);
        }
    }

    /**
     * Altera o valor do campo debug do SDK
     *
     * @param bool $debug Novo valor do campo debug. Campo opcional com default false. Quando true, o SDK grava nos arquivos de log
     * o body das requests feitas para a api e o body das respostas.
     *
     * * @return void
     */
    public function setDebug(bool $debug)
    {
        $this->debug = $debug;

        if ($this->pix !== null) {
            $this->pix->setDebug($debug);
        }

        if ($this->banking !== null) {
            $this->banking->setDebug($debug);
        }

        if ($this->cobranca !== null) {
            $this->cobranca->setDebug($debug);
        }
    }

    /**
     * Altera o valor do campo contaCorrente da SDK
     *
     * @param bool $contaCorrente Novo valor do campo contaCorrente
     *
     * * @return void
     */
    public function setContaCorrente(string $contaCorrente)
    {
        $this->contaCorrente = $contaCorrente;

        if ($this->pix !== null) {
            $this->pix->setContaCorrente($contaCorrente);
        }

        if ($this->banking !== null) {
            $this->banking->setContaCorrente($contaCorrente);
        }

        if ($this->cobranca !== null) {
            $this->cobranca->setContaCorrente($contaCorrente);
        }
    }

    /**
     * Retorna o valor do campo contaCorrente do SDK
     *
     * @return string contaCorrente
     */
    public function getContaCorrente()
    {
        return $this->contaCorrente;
    }

    /**
     * Ambiente das chamadas do SDK - Pode ser hml ou production. Não existe ambiente hml para usuários do SDK.
     * Assim, production está como default.
     *
     * @return string
     */
    public function getAmbiente()
    {
        return $this->ambiente;
    }

    /**
     * Ambiente das chamadas do SDK - Pode ser hml ou production. Não existe ambiente hml para usuários do SDK.
     * Assim, production está como default.
     *
     * @param string $ambiente
     */
    public function setAmbiente(string $ambiente): void
    {
        $this->ambiente = $ambiente;

        if ($this->pix !== null) {
            $this->pix->setAmbiente($ambiente);
        }

        if ($this->banking !== null) {
            $this->banking->setAmbiente($ambiente);
        }

        if ($this->cobranca !== null) {
            $this->cobranca->setAmbiente($ambiente);
        }
    }

}