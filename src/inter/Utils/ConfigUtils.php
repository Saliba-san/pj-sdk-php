<?php

namespace Inter\Utils;

use Inter\Exception\ClientException;
use Inter\Model\Erro;

class ConfigUtils
{

    private static $endpointsConfigfile = __DIR__ . '/config.json';
    private static $errorMessage = "Error loading endpoint file";

    /**
     * @throws ClientException
     */
    public static function getBaseUrl(string $environment, string $type): string
    {
        $file = file_get_contents(self::$endpointsConfigfile);
        $config = json_decode($file, true, 512);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ClientException(self::$errorMessage, new Erro());
        }

        return $config[API][$type][URL][$environment];
    }

    /**
     * @throws ClientException
     */
    public static function getPath(string $type, string $path): array
    {
        $file = file_get_contents(self::$endpointsConfigfile);
        $config = json_decode($file, true, 512);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ClientException(self::$errorMessage, new Erro());
        }

        return $config[API][$type][ENDPOINT][$path];
    }
}