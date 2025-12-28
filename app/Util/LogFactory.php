<?php

namespace Dwes\ProyectoVideoclub\Util;

use Monolog\Logger;;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

/**
 * Class LogFactory
 *
 * Fábrica de loggers basada en Monolog.
 * Centraliza la creación del logger para evitar duplicar configuración
 * (ruta del log, nivel, canal, etc.) en múltiples clases.
 */
class LogFactory {

    public static function getLogger(string $canal = 'VideoclubLogger'): LoggerInterface {
        $log = new Logger($canal);
        $log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/videoclub.log', Logger::DEBUG));

        return $log;
    }
}