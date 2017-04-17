<?php

namespace RemiSan\Ouroboros;

interface MatcherFactory
{
    /**
     * @param string[] $conditions
     *
     * @return ConditionMatcher
     */
    public function getMatcher(array $conditions);
}
