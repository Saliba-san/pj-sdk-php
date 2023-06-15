<?php

namespace Inter\Model;

class IncluirPagamentoLoteBody implements \JsonSerializable
{
    private $meuIdentificador;
    private $pagamentos;

    /**
     * Construtor do Body do método incluirPagamentosEmLote.
     *
     * @param string $meuIdentificador - Obrigatório - Identificador do lote para o cliente.<p>
     * @param string $pagamentos - Obrigatório - Pagamentos a serem efetuados. <p>
     * O array pode conter dois tipos de objetos: <p>
     * . IncluirPagamentoBody<p>
     * . IncluirPagamentoDarfBody
     */
    public function __construct(string $meuIdentificador = null, array $pagamentos = [])
    {
        $this->meuIdentificador = $meuIdentificador;
        $this->pagamentos = $pagamentos;
    }

    /**
     * Retorna o parâmetro $meuIdentificador.
     */
    public function getMeuIdentificador()
    {
        return $this->meuIdentificador;
    }

    /**
     * Altera o meuIdentificador.
     * @param string $meuIdentificador - Obrigatório - Novo valor para o meuIdentificador.<p>
     */
    public function setMeuIdentificador(string $meuIdentificador): void
    {
        $this->meuIdentificador = $meuIdentificador;
    }

    /**
     * Retorna o parâmetro $pagamentos.
     */
    public function getPagamentos()
    {
        return $this->pagamentos;
    }

    /**
     * Altera os pagamentos.
     * @param array $pagamentos - Obrigatório - Novo valor para os pagamentos.<p>
     */
    public function setPagamentos(array $pagamentos): void
    {
        $this->pagamentos = $pagamentos;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'meuIdentificador' => $this->getMeuIdentificador(),
            'pagamentos' => $this->getPagamentos(),
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "pagamentos") {

                foreach ($value as $pagamento) {

                    if($pagamento['tipoPagamento'] === "BOLETO") {
                        $p = new IncluirPagamentoBody();
                        $p->enricher($pagamento);
                    } else {
                        $p = new IncluirPagamentoDarfBody();
                        $p->enricher($pagamento);
                    }

                    $pagamentos[] = $p;

                }

                $this->$key = $pagamentos;

            } else {
                $this->$key = $value;
            }
        }
    }
}