<?php
namespace blueantallan\Lumen\ElasticLogger\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class BaseLogger
{
    /**
     * Available method name
     */
    const METHOD_NAME_ACTIVITY_INFO = 'activityInfo';
    const METHOD_NAME_ACTIVITY_DEBUG = 'activityDebug';
    const METHOD_NAME_ACTIVITY_ERROR = 'activityError';
    const METHOD_NAME_ACTIVITY_WARNING = 'activityWarning';
    const METHOD_NAME_ACTIVITY_NOTICE = 'activityNotice';

    /**
     * Activity Channel
     */
    CONST LOG_CHANNEL_ACTIVITY = 'Activity';

    /**
     * Default log directory name
     */
    CONST DEFAULT_LOG_DIR = 'logs';
    CONST DEFAULT_ABSOLUTE_LOG_DIR = __DIR__.'/../../storage/logs/';

    /**
     * Log path
     * @var string
     */
    private $path;

    /**
     * Log level
     * @var int
     */
    private $logLevel;

    /**
     * Class init method
     */
    public function __construct()
    {
        $this->path = (function_exists('storagePath'))
            ? storage_path(self::DEFAULT_LOG_DIR).'/'
            : self::DEFAULT_ABSOLUTE_LOG_DIR;
    }


    /**
     * process the activity log
     *
     * Available method name
     *  activityInfo
     *  activityDebug
     *  activityError
     *  activityWarning
     *  activityNotice
     *
     * Expecting 2 to 3 parameters
     *
     * First param is the Event Type
     * Second param is the Log message
     * Third param is optional is the context array
     *
     * Sample usage:
     *      $log->activityInfo('Event Type', 'sample message ' . time());
     *
     * @param string $name
     * @param array $arguments
     * @return boolean|string
     */
    public function __call(string $name, array $arguments): bool
    {
        if (empty($arguments) || count($arguments) === 1) {
            return 'Missing parameters';
        }

        /**
         * set the log level
         */
        switch ($name) {
            case self::METHOD_NAME_ACTIVITY_INFO:
                $this->logLevel = Logger::INFO;
                break;
            case self::METHOD_NAME_ACTIVITY_DEBUG:
                $this->logLevel = Logger::DEBUG;
                break;
            case self::METHOD_NAME_ACTIVITY_ERROR:
                $this->logLevel = Logger::ERROR;
                break;
            case self::METHOD_NAME_ACTIVITY_WARNING:
                $this->logLevel = Logger::WARNING;
                break;
            case self::METHOD_NAME_ACTIVITY_NOTICE:
                $this->logLevel = Logger::NOTICE;
                break;
        }


        $eventType = empty($arguments[0]) ? 'Event' : $arguments[0];
        $message = empty($arguments[1]) ? 'Empty message' : $arguments[1];
        $context = isset($arguments[2]) ? $arguments[2] : null;

        $log = '[' . $eventType . '] ' . $message;
        if (!empty($context)) {
            $log .= ' ' . json_encode($context);
        }

        $this->doLog($log);

        return true;
    }

    /**
     * write the log
     * @param string $message
     * @return void
     */
    private function doLog($message): void
    {
        $logfile = $this->path.'activity.log';
        $log = new Logger(self::LOG_CHANNEL_ACTIVITY);

        $dateFormat = 'Y-m-d H:i:s';
        $stream = new StreamHandler($logfile, $this->logLevel);

        $output = "%datetime% %level_name%: %message%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream->setFormatter($formatter);
        $log->pushHandler($stream);

        $log->log($this->logLevel, $message);
    }
}
