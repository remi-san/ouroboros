<?php

namespace RemiSan\Ouroboros\Matcher;

use Assert\Assertion;
use Assert\AssertionFailedException;
use RemiSan\Ouroboros\ConditionMatcher;

class TextConditionMatcher implements ConditionMatcher
{
    /** @var int */
    private $conditionIndex;

    /** @var string[] */
    private $logConditions;

    /**
     * TextConditionMatcher constructor.
     *
     * @param string[] $logConditions
     *
     * @throws AssertionFailedException
     */
    public function __construct(array $logConditions)
    {
        Assertion::notEmpty($logConditions);

        $this->conditionIndex = 0;
        $this->logConditions = $logConditions;
    }

    /**
     * @param mixed $outcome
     *
     * @return bool
     */
    public function matches($outcome)
    {
        // If condition is detected
        if (self::containsCondition($outcome, $this->getCurrentCondition())) {
            ++$this->conditionIndex;

            // If it was the last condition
            if ($this->conditionIndex === count($this->logConditions)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed|string
     */
    private function getCurrentCondition()
    {
        return $this->logConditions[$this->conditionIndex];
    }

    /**
     * @param string $text
     * @param string $condition
     *
     * @return bool
     */
    private static function containsCondition($text, $condition)
    {
        return strpos($text, $condition) !== false;
    }
}
