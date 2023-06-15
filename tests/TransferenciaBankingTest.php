<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Model\Chave;
use Inter\Model\DadosBancarios;
use Inter\Model\Favorecido;
use Inter\Model\IncluirPixBody;
use Inter\Model\IncluirTedBody;
use Inter\Model\InstituicaoFinanceira;
use PHPUnit\Framework\TestCase;

class TransferenciaBankingTest extends TestCase
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

    final public function testIncluirPixChave(): void
    {
        $chave = new Chave("7e537884-6740-43f1-83a3-784e0e905881", "CHAVE");
        $body = new IncluirPixBody("0.01", null, null, $chave);

        try {
            $response = $this->interSdk->banking()
                ->incluirPix($body);
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testIncluirPixBancario(): void
    {
        $instituicaoFinanceira = new InstituicaoFinanceira("077", "Banco Inter", "00416968");
        $dados = new DadosBancarios("9588752", "CONTA_CORRENTE", "90403518000169",
            "0001", "Ricardo", "DADOS_BANCARIOS", $instituicaoFinanceira);
        $body = new IncluirPixBody("0.01", null, null, $dados);

        try {
            $response = $this->interSdk->banking()
                ->incluirPix($body);
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testIncluirTed(): void
    {
        $inst = new InstituicaoFinanceira("077", "Banco Inter", "00416968");
        $favorecido = new Favorecido(null, "Rafael Nunes", "90403518000169", $inst,
            "001", "9588752");
        $body = new IncluirTedBody("CONTA_CORRENTE", "00010", "WEB",
            $favorecido, 1.00, date('Y-m-d'));

        try {
            $response = $this->interSdk->banking()
                ->incluirTed($body);
        } catch (exception $e) {
            var_dump($e);
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

}
