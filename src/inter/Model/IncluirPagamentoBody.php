<?php

namespace Inter\Model;

class IncluirPagamentoBody implements \JsonSerializable
{
    private $codBarraLinhaDigitavel;
    private $valorPagar;
    private $dataPagamento;
    private $dataVencimento;
    private $tipoPagamento;

    /**
     * Construtor do Body do método incluirPagamentoComCodigoDeBarras e parte do Body do método incluirPagamentosEmLote.
     *
     * @param string $codBarraLinhaDigitavel - Obrigatório - Código de barras ou linha digitável.<p>
     * $codBarraLinhaDigitavel = "07797000000000000004501008460019310001802680" <p>
     * @param string $valorPagar - Obrigatório - Valor a ser pago. $valorPagar = "26.80"
     * @param string | null $dataPagamento - Opcional - Data para efetivar o pagamento. <p>
     * Se não informada, o pagamento será feito no mesmo dia. $dataPagamento = "2021-02-01"
     * @param string $dataVencimento - Obrigatório - Data de vencimento do título. $dataVencimento = "2021-02-02"
     * @param string | null $tipoPagamento - Opcional ou Obrigatório - Tipo de Pagamento. <p>
     * Campo obrigatório apenas na inclusão de lote de pagamentos.<p>
     * Valores: <p>
     * . DARF<p>
     * . BOLETO
     */
    public function __construct(string $codBarraLinhaDigitavel = null, string $valorPagar = null,
                                string $dataVencimento = null, string $dataPagamento = null, string $tipoPagamento = null)
    {
        $this->codBarraLinhaDigitavel = $codBarraLinhaDigitavel;
        $this->valorPagar = $valorPagar;
        $this->dataPagamento = $dataPagamento;
        $this->dataVencimento = $dataVencimento;
        $this->tipoPagamento = $tipoPagamento;
    }

    /**
     * Retorna o parâmetro $codBarraLinhaDigitavel.
     */
    final public function getCodBarraLinhaDigitavel()
    {
        return $this->codBarraLinhaDigitavel;
    }

    /**
     * Altera o codBarraLinhaDigitavel.
     * @param string $codBarraLinhaDigitavel - Obrigatório - Novo código de barras ou linha digitável.<p>
     */
    final public function setCodBarraLinhaDigitavel(string $codBarraLinhaDigitavel): void
    {
        $this->codBarraLinhaDigitavel = $codBarraLinhaDigitavel;
    }

    /**
     * Retorna o parâmetro $valorPagar.
     */
    public function getValorPagar()
    {
        return $this->valorPagar;
    }

    /**
     * Altera o valorPagar.
     * @param string $valorPagar - Obrigatório - Novo valor a pagar.<p>
     */
    public function setValorPagar(string $valorPagar): void
    {
        $this->valorPagar = $valorPagar;
    }

    /**
     * Retorna o parâmetro $dataPagamento.
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    /**
     * Altera a dataPagamento.
     * @param string $dataPagamento - Obrigatório - Novo valor para data pagamento.<p>
     */
    public function setDataPagamento(string $dataPagamento): void
    {
        $this->dataPagamento = $dataPagamento;
    }

    /**
     * Retorna o parâmetro $dataVencimento.
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Altera a dataVencimento.
     * @param string $dataVencimento - Obrigatório - Novo valor para data vencimento.<p>
     */
    public function setDataVencimento(string $dataVencimento): void
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * Retorna o parâmetro $tipoPagamento.
     */
    public function getTipoPagamento()
    {
        return $this->tipoPagamento;
    }

    /**
     * Altera o tipoPagamento.
     * @param string $tipoPagamento - Obrigatório - Novo valor para tipo pagamento.<p>
     */
    public function setTipoPagamento(string $tipoPagamento): void
    {
        $this->tipoPagamento = $tipoPagamento;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'dataVencimento' => $this->getDataVencimento(),
            'codBarraLinhaDigitavel' => $this->getCodBarraLinhaDigitavel(),
            'dataPagamento' => $this->getDataPagamento(),
            'tipoPagamento' => $this->getTipoPagamento(),
            'valorPagar' => $this->getValorPagar()
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }
}