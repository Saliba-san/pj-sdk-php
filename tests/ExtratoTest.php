<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use PHPUnit\Framework\TestCase;

class ExtratoTest extends TestCase
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

    final public function testBuscarSaldo(): void
    {
        try {
            $response = $this->interSdk->banking()
                ->consultarSaldo();
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testConsultaExtrato(): void
    {
        try {
            $response = $this->interSdk->banking()
                ->consultarExtrato("2022-04-01", "2022-04-30");
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testConsultaExtratoEnriquecidoPaginado(): void
    {
        try {
            $response = $this->interSdk->banking()
                ->consultarExtratoEnriquecido(true, "2022-04-01", "2022-04-30", null, null, 0);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testConsultaExtratoEnriquecidoNaoPaginado(): void
    {
        try {
            $response = $this->interSdk->banking()
                ->consultarExtratoEnriquecido(false, "2022-04-01", "2022-04-30", null, null, 0);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testRecuperarExtratoPDFDemo(): void
    {
        try {
           $this->assertNull($this->interSdk->banking()
                ->recuperarExtratoPDF("2022-04-01", "2022-04-02", "extrato.pdf"));
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }

    }

}
