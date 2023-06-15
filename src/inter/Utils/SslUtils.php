<?php

namespace Inter\Utils;

use Inter\Exception\CertificadoExpiradoException;
use Inter\Exception\CertificadoNaoEncontrado;
use Inter\Exception\ChaveNaoEncontradaException;
use Inter\Exception\ErroLeituraCertificadoException;
use Inter\Exception\ErroLeituraChaveCertificadoException;

class SslUtils
{
    private static $erroLerCertificado = "Erro ao ler certificado como String.";
    private static $tipoCertificado = "crt";
    private static $erroInfosCertificado = "Erro na obtenção das infos do certificado crt.";
    private static $key = "key";
    private static $validateTo = "validTo_time_t";
    private static $aviso = "Certificado expira em menos de %d dias!! Expira em %s.";

    /**
     * @throws ErroLeituraChaveCertificadoException
     * @throws CertificadoNaoEncontrado
     * @throws ChaveNaoEncontradaException
     * @throws CertificadoExpiradoException
     * @throws ErroLeituraCertificadoException
     */
    public static function valida_certificado(string $certified_path, string $key_path, &$avisos): void
    {

        if (self::certificadoNaoExisteNoPathEspecificado($certified_path)) {
            self::lancaExcecaoCertificadoNaoEncontrado($certified_path);
        }

        $certPath = realpath($certified_path);
        self::verificaContentsCertificado($certPath);
        $certinfo = self::verificaTipagemEInfosDoCertificado($certPath, $certified_path);

        if (self::chaveNaoExisteNoPathEspecificado($key_path)) {
            self::lancaExcecaoChaveNaoEncontrado($key_path);
        }

        $keyPath = realpath($key_path);
        self::verificaTipagemEInfosDaChave($keyPath);
        self::verificaValidadeCertificado($certinfo, $avisos);

    }

    private static function certificadoNaoExisteNoPathEspecificado(string $certified_path): bool
    {
        return !file_exists(realpath($certified_path));
    }

    private static function chaveNaoExisteNoPathEspecificado(string $key_path): bool
    {
        return !file_exists(realpath($key_path));
    }

    /**
     * @throws ErroLeituraCertificadoException
     */
    private static function lancaErroLeituraCertificado(): void
    {
        $e = new ErroLeituraCertificadoException(self::$erroInfosCertificado);
        LogUtils::logMsg(LogUtils::formataMsgException($e), LOGS_ERROR);
        throw $e;
    }

    /**
     * @throws ErroLeituraCertificadoException
     */
    private static function verificaTipagemEInfosDoCertificado(string $certPath, string $certified_path): array
    {
        if (strtolower(substr($certPath, -3)) === self::$tipoCertificado) {
            if (!$certinfo = openssl_x509_parse(file_get_contents($certified_path))) {
                self::lancaErroLeituraCertificado();
            }

            return $certinfo;
        }
        return [];
    }

    /**
     * @throws ErroLeituraChaveCertificadoException
     */
    private static function verificaTipagemEInfosDaChave(string $keyPath): void
    {
        if (!file_get_contents($keyPath) && strtolower(substr($keyPath, -3)) !== self::$key) {
            self::lancaExcecaoErroLeituraChave();
        }
    }

    /**
     * @throws ErroLeituraCertificadoException
     */
    private static function verificaContentsCertificado(string $certPath): void
    {
        if (!file_get_contents($certPath)) {
            self::lancaExcecaoErroLeituraCertificado();
        }
    }

    /**
     * @throws CertificadoExpiradoException
     */
    private static function verificaValidadeCertificado(array $certInfo, &$avisos): void
    {
        $today = date(COMPLETE_DATE_FORMAT);
        $validTo = date(COMPLETE_DATE_FORMAT, $certInfo[self::$validateTo]);
        LogUtils::logMsg(LogUtils::formataCert($certInfo, $validTo) . LINE_BREAK);

        if (strtotime($validTo) <= strtotime($today)) {
            self::lancaExcecaoCertificadoExpirado($validTo);
        }

        $oneMonth = date(COMPLETE_DATE_FORMAT, strtotime("+1 month", strtotime($today)));
        $numberOfSecondsInADay = 86400;

        if (strtotime($validTo) <= strtotime($oneMonth)) {
            $diff = (strtotime($validTo) - strtotime($today)) / $numberOfSecondsInADay;
            $msg = sprintf(self::$aviso, $diff, $validTo);
            array_push($avisos, $msg);
            LogUtils::logMsg($msg, LOGS_WARNING);
        }

    }

    /**
     * @throws CertificadoExpiradoException
     */
    private static function lancaExcecaoCertificadoExpirado(string $validTo): void
    {
        $e = new CertificadoExpiradoException($validTo);
        LogUtils::logMsg(LogUtils::formataMsgException($e), LOGS_ERROR);
        throw $e;
    }

    /**
     * @throws ErroLeituraCertificadoException
     */
    private static function lancaExcecaoErroLeituraCertificado(): void
    {
        $e = new ErroLeituraCertificadoException(self::$erroLerCertificado);
        LogUtils::logMsg(LogUtils::formataMsgException($e), LOGS_ERROR);
        throw $e;
    }

    /**
     * @throws ErroLeituraChaveCertificadoException
     */
    private static function lancaExcecaoErroLeituraChave(): void
    {
        $e = new ErroLeituraChaveCertificadoException();
        LogUtils::logMsg(LogUtils::formataMsgException($e), LOGS_ERROR);
        throw $e;
    }

    /**
     * @throws ChaveNaoEncontradaException
     */
    private static function lancaExcecaoChaveNaoEncontrado(string $key_path): void
    {
        $e = new ChaveNaoEncontradaException($key_path);
        LogUtils::logMsg(LogUtils::formataMsgException($e), LOGS_ERROR);
        throw $e;
    }

    /**
     * @throws CertificadoNaoEncontrado
     */
    private static function lancaExcecaoCertificadoNaoEncontrado(string $certified_path): void
    {
        $e = new CertificadoNaoEncontrado($certified_path);
        LogUtils::logMsg(LogUtils::formataMsgException($e), LOGS_ERROR);
        throw $e;
    }
}