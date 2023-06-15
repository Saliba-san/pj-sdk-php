<?php

namespace Inter\Model;

use JsonSerializable;

class Mensagem implements JsonSerializable
{
    private $linha1;
    private $linha2;
    private $linha3;
    private $linha4;
    private $linha5;

    /**
     * Construtor da classe Mensagem.
     *
     * @param string|null $linha1 - Opcional - Linha 1 do campo de texto do título. $linha1 = "mensagem"<p>
     * @param string|null $linha2 - Opcional - Linha 2 do campo de texto do título. $linha2 = "mensagem"<p>
     * @param string|null $linha3 - Opcional - Linha 3 do campo de texto do título. $linha3 = "mensagem"<p>
     * @param string|null $linha4 - Opcional - Linha 4 do campo de texto do título. $linha4 = "mensagem"<p>
     * @param string|null $linha5 - Opcional - Linha 5 do campo de texto do título. $linha5 = "mensagem"<p>
     */
    public function __construct(string $linha1 = null, string $linha2 = null, string $linha3 = null,
                                string $linha4 = null, string $linha5 = null)
    {
        $this->linha1 = $linha1;
        $this->linha2 = $linha2;
        $this->linha3 = $linha3;
        $this->linha4 = $linha4;
        $this->linha5 = $linha5;
    }

    /**
     * @return string|null
     */
    public function getLinha1()
    {
        return $this->linha1;
    }

    /**
     * @param string $linha1
     */
    public function setLinha1(string $linha1): void
    {
        $this->linha1 = $linha1;
    }

    /**
     * @return string|null
     */
    public function getLinha2()
    {
        return $this->linha2;
    }

    /**
     * @param string $linha2
     */
    public function setLinha2(string $linha2): void
    {
        $this->linha2 = $linha2;
    }

    /**
     * @return string|null
     */
    public function getLinha3()
    {
        return $this->linha3;
    }

    /**
     * @param string $linha3
     */
    public function setLinha3(string $linha3): void
    {
        $this->linha3 = $linha3;
    }

    /**
     * @return string|null
     */
    public function getLinha4()
    {
        return $this->linha4;
    }

    /**
     * @param string $linha4
     */
    public function setLinha4(string $linha4): void
    {
        $this->linha4 = $linha4;
    }

    /**
     * @return string|null
     */
    public function getLinha5()
    {
        return $this->linha5;
    }

    /**
     * @param string $linha5
     */
    public function setLinha5(string $linha5): void
    {
        $this->linha5 = $linha5;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'linha1' => $this->getLinha1(),
            'linha2' => $this->getLinha2(),
            'linha3' => $this->getLinha3(),
            'linha4' => $this->getLinha4(),
            'linha5' => $this->getLinha5()
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