<?php

namespace Inter\Model;

class IncluirTedBody implements \JsonSerializable
{
    private $tipo;
    private $finalidade;
    private $origem;
    private $favorecido;
    private $valor;
    private $dataEfetivacao;
    private $descricao;
    private $datasRecorrencia;

    /**
     * Construtor do Body do método incluirTed.
     *
     * @param string $tipo - Obrigatório - Tipo da transferência.  <p>
     * Valores : <p>
     * . CONTA_CORRENTE
     * . CONTA_POUPANCA
     * @param string $finalidade - Obrigatório - Código da finalidade. $finalidade = "00010"  <p>
     * @param string $origem - Obrigatório - Origem do login. <p>
     * Valores: <p>
     * . WEB
     * . MOBILE
     * @param Favorecido $favorecido - Obrigatório - Objeto Favorecido <p>
     * @param float $valor - Obrigatório - Valor da transferência.<p>
     * Serão aceitos apenas valores acima de R$0.01 para transferências e agendamentos de conta Inter para Inter.<p>
     * Serão aceitos apenas valores acima de R$10.00 para transferências e agendamentos de conta Inter para outra instituição financeira.<p>
     * $valor = 450.68
     * @param string $dataEfetivacao - Obrigatório - Data da transferência. $dataEfetivacao = "2019-03-27"
     * @param string | null $descricao - Opcional - Descrição da transferência. $descricao = "Descrição"
     * @param int | null $datasRecorrencia - Opcional - Datas de recorrencia da transferência.<p>
     * Quantidade de meses sequenciais que a transferência deverá acontecer.
     * Exemplo de preenchimento com valor 3: A transferência acontecerá nos próximos 3 meses para a mesma data,<p>
     * com o mesmo valor para o mesmo favorecido. Caso a data do mês seguinte seja um feriado ou dia não útil,<p>
     * o pagamento será agendado para o próximo dia útil. $datasRecorrencia = 3
     */
    public function __construct(string     $tipo = null, string $finalidade = null, string $origem = null,
                                Favorecido $favorecido = null, float $valor = null, string $dataEfetivacao = null,
                                string     $descricao = null, int $datasRecorrencia = null)
    {
        $this->tipo = $tipo;
        $this->finalidade = $finalidade;
        $this->descricao = $descricao;
        $this->origem = $origem;
        $this->favorecido = $favorecido;
        $this->valor = $valor;
        $this->dataEfetivacao = $dataEfetivacao;
        $this->datasRecorrencia = $datasRecorrencia;
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
     * @return string|null
     */
    public function getFinalidade()
    {
        return $this->finalidade;
    }

    /**
     * @param string $finalidade
     */
    public function setFinalidade(string $finalidade): void
    {
        $this->finalidade = $finalidade;
    }

    /**
     * @return string|null
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * @param string $origem
     */
    public function setOrigem(string $origem): void
    {
        $this->origem = $origem;
    }

    /**
     * @return Favorecido|null
     */
    public function getFavorecido()
    {
        return $this->favorecido;
    }

    /**
     * @param Favorecido $favorecido
     */
    public function setFavorecido(Favorecido $favorecido): void
    {
        $this->favorecido = $favorecido;
    }

    /**
     * @return float|null
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return string|null
     */
    public function getDataEfetivacao()
    {
        return $this->dataEfetivacao;
    }

    /**
     * @param string $dataEfetivacao
     */
    public function setDataEfetivacao(string $dataEfetivacao): void
    {
        $this->dataEfetivacao = $dataEfetivacao;
    }

    /**
     * @return string|null
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return int|null
     */
    public function getDatasRecorrencia()
    {
        return $this->datasRecorrencia;
    }

    /**
     * @param int $datasRecorrencia
     */
    public function setDatasRecorrencia(int $datasRecorrencia): void
    {
        $this->datasRecorrencia = $datasRecorrencia;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'tipo' => $this->getTipo(),
            'finalidade' => $this->getFinalidade(),
            'origem' => $this->getOrigem(),
            'favorecido' => $this->getFavorecido(),
            'valor' => $this->getValor(),
            'dataEfetivacao' => $this->getDataEfetivacao(),
            'descricao' => $this->getDescricao(),
            'datasRecorrencia' => $this->getDatasRecorrencia(),
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "favorecido") {
                $favorecido = new Favorecido();
                $favorecido->enricher($value);
                $this->$key = $favorecido;
            } else {
                $this->$key = $value;
            }
        }
    }
}