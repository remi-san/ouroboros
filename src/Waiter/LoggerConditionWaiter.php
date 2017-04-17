<?php

namespace RemiSan\Ouroboros\Waiter;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Psr\Log\LoggerInterface;
use RemiSan\Ouroboros\ConditionWaiter;
use RemiSan\Ouroboros\MatcherFactory;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class LoggerConditionWaiter implements ConditionWaiter
{
    /**
     * The message from which read the logs.
     */
    public static $DELIMITER = '~~~~~~~~~~~~o~ ∞ οὐροϐóρος ∞ ~o~~~~~~~~~~~~';

    /** @var string */
    private $logFilePath;

    /** @var LoggerInterface */
    private $logger;

    /** @var int */
    private $timeout;

    /** @var MatcherFactory */
    private $matcherFactory;

    /**
     * LoggerConditionWaiter constructor.
     *
     * @param string          $logFilePath    absolute file path
     * @param MatcherFactory  $matcherFactory the matcher factory
     * @param LoggerInterface $logger         the logger to add logs to file
     * @param int             $timeout        in seconds
     *
     * @throws AssertionFailedException
     */
    public function __construct(
        $logFilePath,
        MatcherFactory $matcherFactory,
        LoggerInterface $logger,
        $timeout = 10
    ) {
        Assertion::integer($timeout);
        Assertion::greaterThan($timeout, 0);

        $this->logFilePath = $logFilePath;
        $this->logger = $logger;
        $this->timeout = $timeout;
        $this->matcherFactory = $matcherFactory;
    }

    /**
     * @param string $delimiter
     */
    public static function changeDelimiter($delimiter)
    {
        self::$DELIMITER = $delimiter;
    }

    /**
     * Init the waiter.
     */
    public function init()
    {
        $this->writeDelimiter();
    }

    /**
     * Wait until task completion defined by list of conditions.
     *
     * @param array $conditions
     *
     * @throws \RuntimeException
     * @throws RuntimeException
     * @throws LogicException
     * @throws AssertionFailedException
     */
    public function wait(array $conditions)
    {
        Assertion::file($this->logFilePath);

        $conditionMatcher = $this->matcherFactory->getMatcher($conditions);

        $logProcess = new Process('tail -f ' . $this->logFilePath, null, null, null, $this->timeout);
        $logProcess->start();
        $logProcess->wait(
            function ($type, $buffer) use ($logProcess, $conditionMatcher) {
                // We stop on error
                if ($type !== Process::OUT) {
                    $logProcess->stop(2, SIGTERM);
                    throw new \RuntimeException('There has been an error during execution: ' . $buffer);
                }

                // If tail fails at providing the lines one by one (first return for example)
                $lines = explode(PHP_EOL, self::getStrippedLogLines($buffer));

                foreach ($lines as $line) {
                    // If condition is detected
                    if ($conditionMatcher->matches($line)) {
                        // Stop waiting
                        $logProcess->stop(2, SIGTERM);

                        return;
                    }
                }
            }
        );

        // Wait 10ms to allow everything to settle
        usleep(10000);

        // Write the delimiter message in the log file to prevent any error
        $this->writeDelimiter();
    }

    /**
     * Write the delimiter.
     */
    private function writeDelimiter()
    {
        $this->logger->debug(self::$DELIMITER);
    }

    /**
     * Return the text after the last occurrence of the delimiter text.
     *
     * If the text doesn't contain the delimiter, the whole text is returned.
     *
     * @param string $text
     *
     * @return bool
     */
    private static function getStrippedLogLines($text)
    {
        $pos = strrpos($text, self::$DELIMITER);
        if ($pos === false) {
            return $text;
        }

        $startPos = strpos($text, PHP_EOL, $pos);
        if ($startPos === false) {
            return '';
        }

        return substr($text, $startPos + 1);
    }
}
