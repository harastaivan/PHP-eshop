<?php

namespace EShop;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Logger constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->logger = new MonologLogger($name);
    }

    /**
     * @param string $string
     * @param array $context
     * @throws \Exception
     */
    public function logInfo($string, array $context = [])
    {
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../log/info.log', MonologLogger::INFO));
        $this->logger->info($string, $context);
    }

    /**
     * @param string $string
     * @param array $context
     * @throws \Exception
     */
    public function logWarning($string, array $context = [])
    {
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../log/warning.log', MonologLogger::WARNING));
        $this->logger->warning($string, $context);
    }

    /**
     * @param string $string
     * @param array $context
     * @throws \Exception
     */
    public function logError($string, array $context = [])
    {
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../log/error.log', MonologLogger::ERROR));
        $this->logger->error($string, $context);
    }
}