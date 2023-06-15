<?php

namespace Inter\Model;

use JsonSerializable;

class BoletoBody implements JsonSerializable
{
    private $seuNumero;
    private $valorNominal;
    private $valorAbatimento;
    private $dataVencimento;
    private $numDiasAgenda;
    private $pagador;
    private $mensagem;
    private $desconto1;
    private $desconto2;
    private $desconto3;
    private $multa;
    private $mora;
    private $beneficiarioFinal;

    /**
     * Construtor da classe BoletoBody.
     *
     * @param string $seuNumero - Obrigatório - Campo Seu Número do título. $seuNumero = "123456"<p>
     * @param float $valorNominal - Obrigatório - Valor Nominal do título. <p>
     * O valor nominal deve ser maior ou igual à R$2.50. $valorNominal = "100.00"<p>
     * @param float | null $valorAbatimento - Opcional - Valor de abatimento do título, <p>
     * expresso na mesma moeda do Valor Nominal. $valorAbatimento = "100.00" <p>
     * @param string $dataVencimento - Obrigatório - Data de vencimento do título. $dataVencimento = "2021-01-02" <p>
     * @param int $numDiasAgenda - Obrigatório - Número de dias corridos após o vencimento para o cancelamento efetivo automático do boleto. (de 0 até 60)<p>
     * $numDiasAgenda = 30 <p>
     * @param Pessoa $pagador - Obrigatório - Objeto Pessoa.<p>
     * @param Mensagem | null $mensagem - Opcional - Objeto Mensagem.<p>
     * @param Desconto | null $desconto1 - Opcional - Objeto Desconto.<p>
     * @param Desconto | null $desconto2 - Opcional - Objeto Desconto.<p>
     * @param Desconto | null $desconto3 - Opcional - Objeto Desconto.<p>
     * @param Multa | null $multa - Opcional - Objeto Multa>.<p>
     * @param Mora | null $mora - Opcional - Objeto Mora>.<p>
     * @param Pessoa | null $beneficiarioFinal - Opcional - Objeto Pessoa>.<p>
     */
    public function __construct(string   $seuNumero = null, float $valorNominal = null, float $valorAbatimento = null,
                                string   $dataVencimento = null, int $numDiasAgenda = null, Pessoa $pagador = null,
                                Mensagem $mensagem = null, Desconto $desconto1 = null, Desconto $desconto2 = null,
                                Desconto $desconto3 = null, Multa $multa = null, Mora $mora = null,
                                Pessoa   $beneficiarioFinal = null)
    {
        $this->seuNumero = $seuNumero;
        $this->valorNominal = $valorNominal;
        $this->valorAbatimento = $valorAbatimento;
        $this->dataVencimento = $dataVencimento;
        $this->numDiasAgenda = $numDiasAgenda;
        $this->pagador = $pagador;
        $this->mensagem = $mensagem;
        $this->desconto1 = $desconto1;
        $this->desconto2 = $desconto2;
        $this->desconto3 = $desconto3;
        $this->multa = $multa;
        $this->mora = $mora;
        $this->beneficiarioFinal = $beneficiarioFinal;
    }

    /**
     * @return string|null
     */
    public function getSeuNumero()
    {
        return $this->seuNumero;
    }

    /**
     * @param string $seuNumero
     */
    public function setSeuNumero(string $seuNumero): void
    {
        $this->seuNumero = $seuNumero;
    }

    /**
     * @return float|null
     */
    public function getValorNominal()
    {
        return $this->valorNominal;
    }

    /**
     * @param float $valorNominal
     */
    public function setValorNominal(float $valorNominal): void
    {
        $this->valorNominal = $valorNominal;
    }

    /**
     * @return float|null
     */
    public function getValorAbatimento()
    {
        return $this->valorAbatimento;
    }

    /**
     * @param float $valorAbatimento
     */
    public function setValorAbatimento(float $valorAbatimento): void
    {
        $this->valorAbatimento = $valorAbatimento;
    }

    /**
     * @return string|null
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * @param string $dataVencimento
     */
    public function setDataVencimento(string $dataVencimento): void
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * @return int|null
     */
    public function getNumDiasAgenda()
    {
        return $this->numDiasAgenda;
    }

    /**
     * @param int $numDiasAgenda
     */
    public function setNumDiasAgenda(int $numDiasAgenda): void
    {
        $this->numDiasAgenda = $numDiasAgenda;
    }

    /**
     * @return Pessoa|null
     */
    public function getPagador()
    {
        return $this->pagador;
    }

    /**
     * @param Pessoa $pagador
     */
    public function setPagador(Pessoa $pagador): void
    {
        $this->pagador = $pagador;
    }

    /**
     * @return Mensagem|null
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param Mensagem $mensagem
     */
    public function setMensagem(Mensagem $mensagem): void
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return Desconto|null
     */
    public function getDesconto1()
    {
        return $this->desconto1;
    }

    /**
     * @param Desconto $desconto1
     */
    public function setDesconto1(Desconto $desconto1): void
    {
        $this->desconto1 = $desconto1;
    }

    /**
     * @return Desconto|null
     */
    public function getDesconto2()
    {
        return $this->desconto2;
    }

    /**
     * @param Desconto $desconto2
     */
    public function setDesconto2(Desconto $desconto2): void
    {
        $this->desconto2 = $desconto2;
    }

    /**
     * @return Desconto|null
     */
    public function getDesconto3()
    {
        return $this->desconto3;
    }

    /**
     * @param Desconto $desconto3
     */
    public function setDesconto3(Desconto $desconto3): void
    {
        $this->desconto3 = $desconto3;
    }

    /**
     * @return Multa|null
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * @param Multa $multa
     */
    public function setMulta(Multa $multa): void
    {
        $this->multa = $multa;
    }

    /**
     * @return Mora
     */
    public function getMora()
    {
        return $this->mora;
    }

    /**
     * @param Mora $mora
     */
    public function setMora(Mora $mora): void
    {
        $this->mora = $mora;
    }

    /**
     * @return Pessoa|null
     */
    public function getBeneficiarioFinal()
    {
        return $this->beneficiarioFinal;
    }

    /**
     * @param Pessoa $beneficiarioFinal
     */
    public function setBeneficiarioFinal(Pessoa $beneficiarioFinal): void
    {
        $this->beneficiarioFinal = $beneficiarioFinal;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'seuNumero' => $this->getSeuNumero(),
            'valorNominal' => $this->getValorNominal(),
            'valorAbatimento' => $this->getValorAbatimento(),
            'dataVencimento' => $this->getDataVencimento(),
            'numDiasAgenda' => $this->getNumDiasAgenda(),
            'pagador' => $this->getPagador(),
            'mensagem' => $this->getMensagem(),
            'desconto1' => $this->getDesconto1(),
            'desconto2' => $this->getDesconto2(),
            'desconto3' => $this->getDesconto3(),
            'multa' => $this->getMulta(),
            'mora' => $this->getMora(),
            'beneficiarioFinal' => $this->getBeneficiarioFinal()
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "pagador") {
                $p = new Pessoa();
                $p->enricher($value);
                $this->pagador = $p;

            } elseif ($key === "beneficiarioFinal") {
                $b = new Pessoa();
                $b->enricher($value);
                $this->beneficiarioFinal = $b;

            } elseif ($key === "mensagem") {
                $m = new Mensagem();
                $m->enricher($value);
                $this->mensagem = $m;

            } elseif ($key === "desconto1") {
                $m = new Desconto();
                $m->enricher($value);
                $this->desconto1 = $m;

            } elseif ($key === "desconto2") {
                $m = new Desconto();
                $m->enricher($value);
                $this->desconto2 = $m;

            } elseif ($key === "desconto3") {
                $m = new Desconto();
                $m->enricher($value);
                $this->desconto3 = $m;

            } elseif ($key === "multa") {
                $m = new Multa();
                $m->enricher($value);
                $this->multa = $m;

            } elseif ($key === "mora") {
                $m = new Mora();
                $m->enricher($value);
                $this->mora = $m;

            } else {
                $this->$key = $value;
            }
        }
    }
}