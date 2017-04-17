<?php

namespace RemiSan\Ouroboros\Matcher\Factory;

use Assert\Assertion;
use Assert\AssertionFailedException;
use RemiSan\Ouroboros\ConditionMatcher;
use RemiSan\Ouroboros\Matcher\TextConditionMatcher;
use RemiSan\Ouroboros\MatcherFactory;

class TextConditionMatcherFactory implements MatcherFactory
{
    /** @var string[] */
    private $conditionMapping;

    /**
     * MatcherFactory constructor.
     *
     * @param string[] $conditionMapping
     *
     * @throws AssertionFailedException
     */
    public function __construct(array $conditionMapping = [])
    {
        $this->conditionMapping = [];

        foreach ($conditionMapping as $conditionKeyword => $message) {
            $this->mapCondition($conditionKeyword, $message);
        }
    }

    /**
     * @param string[] $conditions
     *
     * @throws AssertionFailedException
     *
     * @return ConditionMatcher
     */
    public function getMatcher(array $conditions)
    {
        return new TextConditionMatcher($this->resolveConditions($conditions));
    }

    /**
     * @param string $conditionKeyword
     * @param string $message
     *
     * @throws AssertionFailedException
     */
    private function mapCondition($conditionKeyword, $message)
    {
        Assertion::string($conditionKeyword);
        Assertion::string($message);

        $this->conditionMapping[$conditionKeyword] = $message;
    }

    /**
     * @param array $conditions
     *
     * @return array
     */
    private function resolveConditions(array $conditions)
    {
        $logConditions = array_map(function ($condition) {
            return isset($this->conditionMapping[$condition]) ? $this->conditionMapping[$condition] : $condition;
        }, $conditions);

        return $logConditions;
    }
}
