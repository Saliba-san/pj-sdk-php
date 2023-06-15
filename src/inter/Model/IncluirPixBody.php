<?php

namespace Inter\Model;

class IncluirPixBody implements \JsonSerializable
{
    private $valor;
    private $dataPagamento;
    private $descricao;
    private $destinatario;

    /**
     * Construtor do Body do método incluirPix.
     *
     * @param float $valor - Obrigatório - Valor do pagamento PIX. $valor = 43.9 <p>
     * @param string | null $dataPagamento - Opcional - Data do pagamento (String formatada) <p>
     * Se não for informada, será a data atual.  $dataPagamento = "2021-01-01"<p>
     * @param string | null $descricao - Opcional - Descrição - $descricao = "Descrição"
     * @param object $destinatario - Obrigatório - Destinatário <p>
     * O destinatário pode ser um objeto DadosBancarios ou Chave
     */
    public function __construct(float  $valor = null, string $dataPagamento = null, $descricao = null,
                                object $destinatario = null)
    {
        $this->valor = $valor;
        $this->dataPagamento = $dataPagamento;
        $this->descricao = $descricao;
        $this->destinatario = $destinatario;
    }

    /**
     * Retorna o parâmetro $valor.
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Altera o valor.
     * @param float $valor - Obrigatório - Novo valor para o valor.<p>
     */
    public function setValor(float $valor): void
    {
        $this->valor = $valor;
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
     * @param string $dataPagamento - Obrigatório - Novo valor para a dataPagamento.<p>
     */
    public function setDataPagamento(string $dataPagamento): void
    {
        $this->dataPagamento = $dataPagamento;
    }

    /**
     * Retorna o parâmetro $descricao.
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Altera a descrição.
     * @param string $descricao - Obrigatório - Novo valor para a descrição.<p>
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * Retorna o parâmetro $destinatario.
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Altera o destinatario.
     * @param object $destinatario - Obrigatório - Novo valor para o destinatario.<p>
     */
    public function setDestinatario(object $destinatario): void
    {
        $this->destinatario = $destinatario;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'valor' => $this->getValor(),
            'dataPagamento' => $this->getDataPagamento(),
            'descricao' => $this->getDescricao(),
            'destinatario' => $this->getDestinatario(),
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {
            if ($key === "destinatario") {

                if ($value['tipo'] === "CHAVE") {
                    $chave = new Chave();
                    $chave->enricher($value);
                    $this->$key = $chave;
                } else {
                    $dadosBancarios = new DadosBancarios();
                    $dadosBancarios->enricher($value);
                    $this->$key = $dadosBancarios;
                }

            } else {
                $this->$key = $value;
            }
        }
    }
}