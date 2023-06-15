<?php

namespace Inter\Model;

class IncluirPagamentoDarfBody implements \JsonSerializable
{
    private $cnpjCpf;
    private $codigoReceita;
    private $dataVencimento;
    private $descricao;
    private $nomeEmpresa;
    private $telefoneEmpresa;
    private $periodoApuracao;
    private $valorPrincipal;
    private $valorMulta;
    private $valorJuros;
    private $referencia;
    private $tipoPagamento;

    /**
     * Construtor do Body do método incluirPagamentoDarf e parte do Body do método incluirPagamentosEmLote.
     *
     * @param string $cnpjCpf - Obrigatório - CPF ou CNPJ.<p>
     * $cnpjCpf = "18378865790" <p>
     * @param string $codigoReceita - Obrigatório - Código Receita. $codigoReceita = "678"
     * @param string | null $descricao - Obrigatório - Descrição. <p>
     * $descricao = "Aqui consta a descrição"
     * @param string $dataVencimento - Obrigatório - Data de vencimento. $dataVencimento = "2021-02-02"
     * @param string $nomeEmpresa - Obrigatório - Nome da empresa. $nomeEmpresa = "Minha Empresa"<p>
     * @param string | null $telefoneEmpresa - Opcional - Telefone da empresa. $telefoneEmpresa = "858574839"<p>
     * @param string $periodoApuracao - Obrigatório - Campo para informar o período de apuração da DARF. $periodoApuracao = "2020-01-31"<p>
     * @param string $valorPrincipal - Obrigatório - Campo para informar o valor principal. $valorPrincipal = "23.8"
     * @param string | null $valorMulta - Opcional - Campo para informar o valor da multa. $valorMulta = "23.8"
     * @param string | null $valorJuros - Opcional - Campo para informar o valor do juros. $valorJuros = "23.8"
     * @param string $referencia - Obrigatório - Campo para informar a referência da DARF. $referencia = "23448488"
     * @param string | null $tipoPagamento - Opcional ou Obrigatório - Tipo de Pagamento. <p>
     * Campo obrigatório apenas na inclusão de lote de pagamentos.<p>
     * Valores: <p>
     * . DARF<p>
     * . BOLETO
     */
    public function __construct(string $cnpjCpf = null, string $codigoReceita = null,
                                string $descricao = null, string $dataVencimento = null, string $nomeEmpresa = null,
                                string $telefoneEmpresa = null, string $periodoApuracao = null,
                                string $valorPrincipal = null, string $valorMulta = null,
                                string $valorJuros = null, string $referencia = null, string $tipoPagamento = null)
    {
        $this->cnpjCpf = $cnpjCpf;
        $this->codigoReceita = $codigoReceita;
        $this->descricao = $descricao;
        $this->dataVencimento = $dataVencimento;
        $this->nomeEmpresa = $nomeEmpresa;
        $this->telefoneEmpresa = $telefoneEmpresa;
        $this->periodoApuracao = $periodoApuracao;
        $this->valorPrincipal = $valorPrincipal;
        $this->valorMulta = $valorMulta;
        $this->valorJuros = $valorJuros;
        $this->referencia = $referencia;
        $this->tipoPagamento = $tipoPagamento;

    }

    /**
     * Retorna o parâmetro $cnpjCpf.
     */
    public function getCnpjCpf()
    {
        return $this->cnpjCpf;
    }

    /**
     * Altera o cnpjCpf.
     * @param string $cnpjCpf - Obrigatório - Novo valor para o cnpjCpf.<p>
     */
    public function setCnpjCpf(string $cnpjCpf): void
    {
        $this->cnpjCpf = $cnpjCpf;
    }

    /**
     * Retorna o parâmetro $codigoReceita.
     */
    public function getCodigoReceita()
    {
        return $this->codigoReceita;
    }

    /**
     * Altera o codigoReceita.
     * @param string $codigoReceita - Obrigatório - Novo valor para o codigoReceita.<p>
     */
    public function setCodigoReceita(string $codigoReceita): void
    {
        $this->codigoReceita = $codigoReceita;
    }

    /**
     * Retorna o parâmetro $descricao.
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Altera a descricao.
     * @param string $descricao - Obrigatório - Novo valor para a descricao.<p>
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
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
     * @param string $dataVencimento - Obrigatório - Novo valor para dataVencimento.<p>
     */
    public function setDataVencimento(string $dataVencimento): void
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * Retorna o parâmetro $nomeEmpresa.
     */
    public function getNomeEmpresa()
    {
        return $this->nomeEmpresa;
    }

    /**
     * Altera o nomeEmpresa.
     * @param string $nomeEmpresa - Obrigatório - Novo valor para nomeEmpresa.<p>
     */
    public function setNomeEmpresa(string $nomeEmpresa): void
    {
        $this->nomeEmpresa = $nomeEmpresa;
    }

    /**
     * Retorna o parâmetro $telefoneEmpresa.
     */
    public function getTelefoneEmpresa()
    {
        return $this->telefoneEmpresa;
    }

    /**
     * Altera o telefoneEmpresa.
     * @param string telefoneEmpresa - Obrigatório - Novo valor para telefoneEmpresa.<p>
     */
    public function setTelefoneEmpresa(string $telefoneEmpresa): void
    {
        $this->telefoneEmpresa = $telefoneEmpresa;
    }

    /**
     * Retorna o parâmetro $periodoApuracao.
     */
    public function getPeriodoApuracao()
    {
        return $this->periodoApuracao;
    }

    /**
     * Altera o periodoApuracao.
     * @param string $periodoApuracao - Obrigatório - Novo valor para periodoApuracao.<p>
     */
    public function setPeriodoApuracao(string $periodoApuracao): void
    {
        $this->periodoApuracao = $periodoApuracao;
    }

    /**
     * Retorna o parâmetro $valorPrincipal.
     */
    public function getValorPrincipal()
    {
        return $this->valorPrincipal;
    }

    /**
     * Altera o valorPrincipal.
     * @param string $valorPrincipal - Obrigatório - Novo valor para valorPrincipal.<p>
     */
    public function setValorPrincipal(string $valorPrincipal): void
    {
        $this->valorPrincipal = $valorPrincipal;
    }

    /**
     * Retorna o parâmetro $valorMulta.
     */
    public function getValorMulta()
    {
        return $this->valorMulta;
    }

    /**
     * Altera o valorMulta.
     * @param string $valorMulta - Obrigatório - Novo valor para valorMulta.<p>
     */
    public function setValorMulta(string $valorMulta): void
    {
        $this->valorMulta = $valorMulta;
    }

    /**
     * Retorna o parâmetro $valorJuros.
     */
    public function getValorJuros()
    {
        return $this->valorJuros;
    }

    /**
     * Altera o valorJuros.
     * @param string $valorJuros - Obrigatório - Novo valor para valorJuros.<p>
     */
    public function setValorJuros(string $valorJuros): void
    {
        $this->valorJuros = $valorJuros;
    }

    /**
     * Retorna o parâmetro $referencia.
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Altera a referencia.
     * @param string $referencia - Obrigatório - Novo valor para referencia.<p>
     */
    public function setReferencia(string $referencia): void
    {
        $this->referencia = $referencia;
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
            'cnpjCpf' => $this->getCnpjCpf(),
            'codigoReceita' => $this->getCodigoReceita(),
            'dataVencimento' => $this->getDataVencimento(),
            'descricao' => $this->getDescricao(),
            'nomeEmpresa' => $this->getNomeEmpresa(),
            'periodoApuracao' => $this->getPeriodoApuracao(),
            'referencia' => $this->getReferencia(),
            'telefoneEmpresa' => $this->getTelefoneEmpresa(),
            'valorJuros' => $this->getValorJuros(),
            'valorMulta' => $this->getValorMulta(),
            'valorPrincipal' => $this->getValorPrincipal(),
            'tipoPagamento' => $this->getTipoPagamento()
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