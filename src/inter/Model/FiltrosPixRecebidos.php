<?php

namespace Inter\Model;

class FiltrosPixRecebidos
{
    private $cpf;
    private $cnpj;
    private $txId;
    private $txIdPresente;
    private $devolucaoPresente;

    /**
     * Construtor do objeto de FiltrosPixRecebidos.
     *
     * @param string | null $cpf - Opcional - Filtro pelo CPF do devedor. Não pode ser utilizado ao mesmo tempo que o CNPJ. $cpf = "48502274903"<p>
     * @param string | null $cnpj - Opcional - Filtro pelo CNPJ do devedor. Não pode ser utilizado ao mesmo tempo que o CPF. $cnpj = "12395678000195"<p>
     * @param string | null $txId - Opcional - Filtro pelo txId. $txId = "6nppey41o0sftu2yzw5onbmyup0zhooun1c"<p>
     * @param bool | null $txIdPresente - Opcional - Filtra pelo txIdPresente. $txIdPresente = true<p>
     * @param bool | null $devolucaoPresente - Opcional - Filtra pelo devolucaoPresente. $devolucaoPresente = true<p>
     */
    public function __construct(string $cpf = null, string $cnpj = null, string $txId = null, bool $txIdPresente = null, bool $devolucaoPresente = null)
    {
        $this->cpf = $cpf;
        $this->cnpj = $cnpj;
        $this->txId = $txId;
        $this->txIdPresente = $txIdPresente;
        $this->devolucaoPresente = $devolucaoPresente;

    }

    /**
     * @return string|null
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string|null
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     */
    public function setCnpj(string $cnpj): void
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return string|null
     */
    public function getTxId()
    {
        return $this->txId;
    }

    /**
     * @param string $txId
     */
    public function setTxId(string $txId): void
    {
        $this->txId = $txId;
    }

    /**
     * @return bool|null
     */
    public function getTxIdPresente()
    {
        return $this->txIdPresente;
    }

    /**
     * @param bool $txIdPresente
     */
    public function setTxIdPresente(bool $txIdPresente): void
    {
        $this->txIdPresente = $txIdPresente;
    }

    /**
     * @return bool|null
     */
    public function getDevolucaoPresente(): ?bool
    {
        return $this->devolucaoPresente;
    }

    /**
     * @param bool|null $devolucaoPresente
     */
    public function setDevolucaoPresente(?bool $devolucaoPresente): void
    {
        $this->devolucaoPresente = $devolucaoPresente;
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