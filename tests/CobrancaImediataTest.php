<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Model\Calendario;
use Inter\Model\CobrancaBody;
use Inter\Model\Devedor;
use Inter\Model\FiltrosCobrancaImediata;
use Inter\Model\Paginacao;
use Inter\Model\Valor;
use PHPUnit\Framework\TestCase;

class CobrancaImediataTest extends TestCase
{

    protected $interSdk;

    /**
     * @throws ErroLeituraChaveCertificadoException
     * @throws CertificadoNaoEncontrado
     * @throws ChaveNaoEncontradaException
     * @throws ErroLeituraCertificadoException
     * @throws CertificadoExpiradoException
     */
    final public function setUp(): void
    {
        $this->interSdk = TestUtils::getSdk();
    }

    final public function testConsultarCobrancaImediata(): void
    {
        try {
            $response = $this->interSdk->pix()
                ->consultarCobrancaImediata("miu4pu5haa42faqztrbpij61dxsjt55d6p0");
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testConsultarListaCobrancasImediatas(): void
    {
        $pag = new Paginacao(0, 200);
        $fil = new FiltrosCobrancaImediata(null, null, null, null);

        try {
            $response = $this->interSdk->pix()
                ->consultarListaCobrancasImediatas(true, "2023-01-01T00:00:00Z",
                    "2023-02-28T00:00:00Z", $fil, $pag);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testCriarCobrancaImediata(): void
    {
        $calendario = new Calendario(86400);
        $devedor = new Devedor("Rafael Nunes", "90388459018", null);
        $valor = new Valor("0.01");
        $body = new CobrancaBody($calendario, $valor, "90403518000169", $devedor); // Necessário trocar Chave

        try {
            $response = $this->interSdk->pix()->criarCobrancaImediata($body);
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testCriarCobrancaImediataTxId(): void
    {
        $calendario = new Calendario(86400);
        $devedor = new Devedor("Rafael Nunes", "90388459018", null);
        $valor = new Valor("0.01");
        $body = new CobrancaBody($calendario, $valor, "90403518000169", $devedor); // Necessário trocar Chave

        try {
            $response = $this->interSdk->pix()->criarCobrancaImediataTxId("34f656b2fb444ba4aeefecda1878e102", $body);
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testRevisarCobrancaImediata(): void
    {
        $calendario = new Calendario(86400);
        $devedor = new Devedor("Rafael Nunes", "90388459018", null);
        $valor = new Valor("0.07");
        $body = new CobrancaBody($calendario, $valor, "90403518000169", $devedor);

        try {
            $response = $this->interSdk->pix()->revisarCobrancaImediata("7y6i0s9bnki4qecpzvrhpufgb30rgjocmvk", $body); // Necessário trocar Chave
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }
}
