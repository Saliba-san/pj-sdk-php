<?php

namespace Inter\Model;

class Erro
{
    public $title;
    public $detail;
    public $timestamp;
    public $message;
    public $correlationId;
    public $violacoes = [];

    public function __construct(string $title = '', string $detail = '', string $message = '', string $timestamp = '', array $violacoes = [], string $correlationId = '')
    {
        $this->title = $title;
        $this->detail = $detail;
        $this->timestamp = $timestamp;
        $this->message = $message;
        $this->violacoes = $violacoes;
        $this->correlationId = $correlationId;

    }

    public function set($data): void
    {
        foreach ($data as $key => $value) {
            $violations = "violacoes";

            if ($key !== $violations) {
                $this->{$key} = $value;
            } else {
                foreach ($value as $violationElement) {
                    $violacao = $this->enrichViolation($violationElement);
                    array_push($this->violacoes, $violacao);
                }
            }
        }
    }

    private function enrichViolation(object $violationElement): Violacao
    {
        $violacao = new Violacao();

        foreach ($violationElement as $violationKey => $violationValue) {
            $violacao->{$violationKey} = $violationValue;
        }

        return $violacao;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCorrelationId()
    {
        return $this->correlationId;
    }

    public function getDetail()
    {
        return $this->detail;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getViolacoes()
    {
        return $this->violacoes;
    }

    public function setTitle($title)
    {
        $this->titulo = $title;
    }

    public function setCorrelationId($correlationId)
    {
        $this->correlationId = $correlationId;
    }

    public function setDetail($detail)
    {
        $this->detalhes = $detail;
    }

    public function setTimestamp($timestamp)
    {
        $this->detalhes = $timestamp;
    }

    public function setMessage($message)
    {
        $this->detalhes = $message;
    }

    public function setViolacoes($violacoes)
    {
        $this->violacoes = $violacoes;
    }

}