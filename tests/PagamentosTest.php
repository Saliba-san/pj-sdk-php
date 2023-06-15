<?php

namespace Tests;

include_once __DIR__ . '/TestUtils.php';

use Exception;
use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;
use Inter\Model\IncluirPagamentoBody;
use Inter\Model\IncluirPagamentoDarfBody;
use Inter\Model\IncluirPagamentoLoteBody;
use PHPUnit\Framework\TestCase;

class PagamentosTest extends TestCase
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

    final public function testBuscarPagamentos(): void
    {
        $dataInicio = "2022-04-01";
        $dataFim = "2022-04-30";
        $codBarraLinhaDigitavel = null;
        $codigoTransacao = null;
        $filtrarDataPor = null;

        try {
            $response = $this->interSdk->banking()
                ->buscarPagamentos($dataInicio, $dataFim, $codBarraLinhaDigitavel,
                    $codigoTransacao, $filtrarDataPor);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testBuscarPagamentosDarf(): void
    {
        $dataInicio = "2022-04-01";
        $dataFim = "2022-04-30";

        try {
            $response = $this->interSdk->banking()
                ->buscarPagamentosDarf($dataInicio, $dataFim);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testBuscarLotePagamentos(): void
    {
        $idLote = "640b2ec2c38e001e2a3f3d32";

        try {
            $response = $this->interSdk->banking()
                ->buscarLotePagamentos($idLote);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testIncluirPagamentoComCodigoDeBarras(): void
    {
        $body = new IncluirPagamentoBody("83600000001312901380010352598733308090321566",
            "131.29", date('Y-m-d'), date('Y-m-d'));


        try {
            $response = $this->interSdk->banking()
                ->incluirPagamentoComCodigoDeBarras($body);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testIncluirPagamentoDarf(): void
    {
        $body = new IncluirPagamentoDarfBody('90388459018', "0191",
            "Descricao nao pode ser nulo", date('Y-m-d'),
            "Inter", null, "2023-06-11", "0.01", null,
            null, "123450");

        try {
            $response = $this->interSdk->banking()
                ->incluirPagamentoDarf($body);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }

    final public function testIncluirPagamentosEmLote(): void
    {
        $pagamento1 = new IncluirPagamentoBody("83600000001312901380010352598733308090321566", "131.29", date('Y-m-d'), "2023-07-09", "BOLETO");
        $pagamento2 = new IncluirPagamentoDarfBody('90388459018', "0191", null,  date('Y-m-d'),
            "Inter", null, "2023-06-06", "0.01", null,
            null, "213456", "DARF");
        $body = new IncluirPagamentoLoteBody(null, array($pagamento1, $pagamento2));

        try {
            $response = $this->interSdk->banking()
                ->incluirPagamentosEmLote($body);
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);

    }
}
