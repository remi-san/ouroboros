<?php

namespace RemiSan\Ouroboros;

interface ConditionMatcher
{
    /**
     * @param mixed $outcome
     *
     * @return bool
     */
    public function matches($outcome);
}
