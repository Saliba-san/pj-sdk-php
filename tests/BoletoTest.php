<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Model\BoletoBody;
use Inter\Model\FiltrosColecaoBoletos;
use Inter\Model\Ordenacao;
use Inter\Model\Paginacao;
use Inter\Model\Pessoa;
use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase
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

    final public function testRecuperarSumarioDeBoletos(): void
    {
        try {
            $response = $this->interSdk->cobranca()
                ->recuperarSumarioDeBoletos("2023-01-01", "2023-02-28");
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testRecuperarColecaoDeBoletosPaginado(): void
    {
        $pag = new Paginacao(0, 1000);
        $ord = new Ordenacao(null, null);
        $fil = new FiltrosColecaoBoletos(null, null, null,
            null, null, null);

        try {
            $response = $this->interSdk->cobranca()
                ->recuperarColecaoDeBoletos(true, "2023-01-01",
                    "2023-02-28", $ord, $fil, $pag);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testRecuperarBoletoEmPDF(): void
    {
        try {
            $this->assertNull($this->interSdk->cobranca()->recuperarBoletoEmPDF("00789691286", "boleto.pdf"));
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
    }

    final public function testRecuperarBoletoDetalhado(): void
    {
        try {
            $response = $this->interSdk->cobranca()->recuperarBoletoDetalhado("00789696483");

        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testEmitirBoletoDeCobranca(): void
    {
        $pagador = new Pessoa("90388459018", "FISICA", "Ricardo",
            "Casa do Ricardo", null, null, null,
            "BH", "MG", "30000000", null, null, null);
        $body = new BoletoBody("03011503", 2.5, null,
            "2023-04-02", 0, $pagador, null);

        try {
            $response = $this->interSdk->cobranca()
                ->emitirBoletoDeCobranca($body);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testCancelarBoleto(): void
    {
        try {
            $this->assertNull($this->interSdk->cobranca()->cancelarBoleto("00789691286", "APEDIDODOCLIENTE"));
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
    }

}
