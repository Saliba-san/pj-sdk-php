<?php

namespace Inter\Model;

class InstituicaoFinanceira implements \JsonSerializable
{
    private $codigo;
    private $nome;
    private $ispb;
    private $tipo;

    /**
     * Construtor do objeto InstituicaoFinanceira.
     *
     * @param string $codigo - Obrigatório - Código do Banco. $codigo = "077"<p>
     * @param string $nome - Obrigatório - Nome do banco. $nome = "Banco Inter" <p>
     * @param string| null $ispb - Opcional - Código ISPB, de 8 dígitos, dos bancos - $ispb = "01234567"
     * @param string $tipo - Obrigatório - Tipos de pagamentos que podem ser realizados. Por chave pix ou por dados bancários.<p>
     * Valores: <p>
     * . CHAVE<p>
     * . DADOS_BANCARIOS<p>
     */
    public function __construct(string $codigo = null, string $nome = null,
                                string $ispb = null, string $tipo = null)
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->ispb = $ispb;
        $this->tipo = $tipo;
    }

    /**
     * @return string|null
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string|null
     */
    public function getIspb()
    {
        return $this->ispb;
    }

    /**
     * @param string $ispb
     */
    public function setIspb(string $ispb): void
    {
        $this->ispb = $ispb;
    }

    /**
     * @return string|null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }


    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'codigo' => $this->getCodigo(),
            'nome' => $this->getNome(),
            'ispb' => $this->getIspb(),
            'tipo' => $this->getTipo(),
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