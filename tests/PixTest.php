<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Model\Devolucao;
use Inter\Model\FiltrosPixRecebidos;
use Inter\Model\Paginacao;
use PHPUnit\Framework\TestCase;

class PixTest extends TestCase
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

    final public function testConsultarPix(): void
    {
        try {
            $response = $this->interSdk->pix()
                ->consultarPix("E17184037202302022054qlNqeoz24ly");
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testConsultarPixRecebidos(): void
    {
        $pag = new Paginacao(0, 1000);
        $fil = new FiltrosPixRecebidos(null, null, null, null, null);
        try {
            $response = $this->interSdk->pix()
                ->consultarPixRecebidos(true, "2023-01-01T00:00:00Z", "2023-02-28T00:00:00Z", $fil, $pag);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testSolicitarDevolucao(): void
    {
        $devolucao = new Devolucao("0.01", null, null);
        try {
            $response = $this->interSdk->pix()
                ->solicitarDevolucao("E17184037202302022054qlNqeoz24ly", "0302231009", $devolucao); // Id deve ser trocado para um novo valor a cada chamada
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testConsultarDevolucao(): void
    {
        try {
            $response = $this->interSdk->pix()
                ->consultarDevolucao("E17184037202302022054qlNqeoz24ly", "0302231153");
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

}
