<?php

namespace Inter\Model;

class Valor implements \JsonSerializable
{
    private $original;
    private $modalidadeAlteracao;
    private $retirada;

    /**
     * Construtor do objeto Valor.
     *
     * @param string $original - Obrigatório - Valor original da cobrança. $original = "37.00"<p>
     * @param int| null $modalidadeAlteracao - Opcional - Trata-se de um campo que determina se o valor final do<p>
     * documento pode ser alterado pelo pagador.<p>
     * Na ausência desse campo, assume-se que não se pode alterar o valor do documento de cobrança, ou seja,<p>
     * assume-se o valor 0. Se o campo estiver presente e com valor 1, então está determinado que o valor final<p>
     * da cobrança pode ter seu valor alterado pelo pagador.
     * $modalidadeAlteracao = 1<p>
     * @param Retirada | null $retirada - Opcional - Objeto Retirada
     */
    public function __construct(string   $original = null, int $modalidadeAlteracao = null,
                                Retirada $retirada = null)
    {
        $this->original = $original;
        $this->modalidadeAlteracao = $modalidadeAlteracao;
        $this->retirada = $retirada;
    }

    /**
     * @return string|null
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @param string $original
     */
    public function setOriginal(string $original): void
    {
        $this->original = $original;
    }

    /**
     * @return int|null
     */
    public function getModalidadeAlteracao()
    {
        return $this->modalidadeAlteracao;
    }

    /**
     * @param int $modalidadeAlteracao
     */
    public function setModalidadeAlteracao(int $modalidadeAlteracao): void
    {
        $this->modalidadeAlteracao = $modalidadeAlteracao;
    }

    /**
     * @return Retirada|null
     */
    public function getRetirada()
    {
        return $this->retirada;
    }

    /**
     * @param Retirada $retirada
     */
    public function setRetirada(Retirada $retirada): void
    {
        $this->retirada = $retirada;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'original' => $this->getOriginal(),
            'modalidadeAlteracao' => $this->getModalidadeAlteracao(),
            'retirada' => $this->getRetirada()
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "retirada") {
                $val = new Retirada();
                $val->enricher($value);
                $this->retirada = $val;
            } else {
                $this->$key = $value;
            }

        }
    }
}