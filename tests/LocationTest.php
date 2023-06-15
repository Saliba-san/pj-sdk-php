<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Model\Paginacao;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
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

    final public function testCriarLocationDoPayload(): void
    {
        try {
            $response = $this->interSdk->pix()
                ->criarLocationDoPayload("cob");
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testConsultarLocationsCadastradas(): void
    {
        $pag = new Paginacao(1, 5);

        try {
            $response = $this->interSdk->pix()
                ->consultarLocationsCadastradas(true,
                    "2023-01-01T00:00:00Z", "2023-02-28T00:00:00Z", false, "cob", $pag);
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testRecuperarLocationDoPayload(): void
    {
        try {
            $response = $this->interSdk->pix()
                ->recuperarLocationDoPayload("892142"); // Trocar ID
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testDesvincularCobrancaLocation(): void
    {
        try {
            $response = $this->interSdk->pix()
                ->desvincularCobrancaLocation("895635");
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }
}
