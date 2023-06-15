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

class WebhookBankingTest extends TestCase
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

    final public function testCriarWebhook(): void
    {
        try {
            $this->assertNull($this->interSdk->banking()
                ->criarWebhook("https://webhook.site/b166ebb1-d9ed-4215-82b8-147828761cf6", "pix-pagamento"));
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
    }

    final public function testObterWebhookCadastrado(): void
    {
        try {
            $response = $this->interSdk->banking()
                ->obterWebhookCadastrado( "pix-pagamento");
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
        $this->assertNotNull($response);
    }

    final public function testExcluirWebhook(): void
    {
        try {
            $this->assertNull($this->interSdk->banking()
                ->excluirWebhook("pix-pagamento"));
        } catch (exception $e) {
            $this->fail("Exception lançada: " . json_encode($e));
        }
    }

}
