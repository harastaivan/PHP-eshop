<?php

namespace EShop;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    /**
     * @var bool $initialized
     */
    private static $initialized = false;

    /**
     * @var string $name
     */
    private static $name = 'logger';

    /**
     * @var MonologLogger $logger
     */
    private static $logger;

    /**
     * Logger constructor.
     */
    private static function initialize()
    {
        if (self::$initialized) {
            return;
        }
        self::$logger = new MonologLogger(self::$name);
        self::$initialized = true;
    }

    /**
     * @param string $string
     * @param array $context
     * @throws \Exception
     */
    public static function logInfo($string, array $context = [])
    {
        self::initialize();
        self::$logger->pushHandler(new StreamHandler(__DIR__ . '/../log/info.log', MonologLogger::INFO));
        self::$logger->info($string, $context);
    }

    /**
     * @param string $string
     * @param array $context
     * @throws \Exception
     */
    public static function logWarning($string, array $context = [])
    {
        self::initialize();
        self::$logger->pushHandler(new StreamHandler(__DIR__ . '/../log/warning.log', MonologLogger::WARNING));
        self::$logger->warning($string, $context);
    }

    /**
     * @param string $string
     * @param array $context
     * @throws \Exception
     */
    public static function logError($string, array $context = [])
    {
        self::initialize();
        self::$logger->pushHandler(new StreamHandler(__DIR__ . '/../log/error.log', MonologLogger::ERROR));
        self::$logger->error($string, $context);
    }
}