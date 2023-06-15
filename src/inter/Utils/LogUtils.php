<?php

namespace Inter\Utils;

use Inter\Exception\SdkException;

class LogUtils
{
    private static $CERT_EXPIRATION = 'Certificado: Data de Expiração: ';
    private static $EXCEPTION = 'Exceção: ';
    private static $ERROR_OBJECT = "Objeto Erro: ";
    private static $CERT_ISSUER = 'issuer';
    private static $TITLE = "Titulo: ";
    private static $MESSAGE = "Message: ";
    private static $DETAIL = "Detalhes: ";
    private static $CORRELATION_ID = "Correlation ID: ";
    private static $VIOLATIONS = "Violacoes: ";
    private static $STACK_TRACE = "Stack Trace: ";
    private static $MANY_REQUESTS = "Many Requests - 429 - URL : ";

    private static $WARNING = "WARNING";
    private static $ERROR = "ERROR";
    private static $INFO = "INFO";

    public static function formataCert(array $certInfo, string $validTo): string
    {
        return self::$CERT_EXPIRATION . $validTo . LINE_BREAK
            . json_encode($certInfo[self::$CERT_ISSUER]);
    }

    public static function formata429(string $url)
    {
        return self::$MANY_REQUESTS . $url;
    }

    public static function formataMsgException(SdkException $ex): string
    {
        $msg = self::$EXCEPTION . LINE_BREAK;

        if ($ex->getMessage() !== null) {
            $msg .= self::$MESSAGE . $ex->getMessage() . LINE_BREAK;
        }

        $msg .= self::$ERROR_OBJECT . LINE_BREAK;

        if ($ex->getErro()->title !== null) {
            $msg .= self::$TITLE . $ex->getErro()->title . LINE_BREAK;
        }

        if ($ex->getErro()->message !== null) {
            $msg .= self::$MESSAGE . $ex->getErro()->message . LINE_BREAK;
        }

        if ($ex->getErro()->detail !== null) {
            $msg .= self::$DETAIL . $ex->getErro()->detail . LINE_BREAK;
        }

        if ($ex->getErro()->correlationId !== null) {
            $msg .= self::$CORRELATION_ID . $ex->getErro()->correlationId . LINE_BREAK;
        }

        if ($ex->getErro()->violacoes !== null) {

            $msg .= self::$VIOLATIONS;

            foreach ($ex->getErro()->violacoes as $violacao) {
                self::preencheViolacao($msg, $violacao);
                $msg .= LINE_BREAK;
            }
        }

        $msg .= self::$STACK_TRACE . LINE_BREAK . $ex->getTraceAsString();

        return $msg;
    }

    private static function preencheViolacao(&$msg, $violacao): void
    {
        foreach ($violacao as $nomeViolacao => $valorViolacao) {
            $msg .= $nomeViolacao . TWO_POINTS . $valorViolacao . LINE_BREAK;
        }
    }

    public static function logMsg(string $msg = '', string $level = LOGS_INFO): void
    {
        $levelStr = self::buscaNivelDoLog($level);
        $logDate = date(COMPLETE_DATE_FORMAT);

        $date = date(SIMPLE_DATE_FORMAT);
        $file = sprintf(LOGS_NAME, $date);
        $shouldExclude = self::devo_excluir_arquivo($file);

        if ($shouldExclude) {

            $weekInSeconds = 7 * 24 * 60 * 60;
            $pastWeek = time() - $weekInSeconds;
            $oldFileDate = date(SIMPLE_DATE_FORMAT, $pastWeek);
            $oldFile = sprintf(LOGS_NAME, $oldFileDate);

            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $msg = sprintf(LOGS_FORMAT, $logDate, $levelStr, $msg, PHP_EOL);

        file_put_contents($file, $msg, LOCK_EX | FILE_APPEND);
    }

    private static function devo_excluir_arquivo(string $file): bool
    {
        return !file_exists($file);
    }

    public static function buscaNivelDoLog(string $level = LOGS_INFO): string
    {

        if ($level == LOGS_ERROR) {
            return self::$ERROR;
        }

        if ($level == LOGS_WARNING) {
            return self::$WARNING;
        }

        return self::$INFO;
    }

    public static function verificaExistenciaDeArquivoDeLog(): void
    {
        if (!file_exists(LOGS_PATH)) {
            $permissions = 0770;
            mkdir(LOGS_PATH, $permissions);
        }
    }

}