<?php

namespace RemiSan\Ouroboros\Waiter;

use Assert\AssertionFailedException;
use LogicException;
use RemiSan\Ouroboros\ConditionWaiter;
use Symfony\Component\Process\Exception\RuntimeException;

class NullConditionWaiter implements ConditionWaiter
{
    /**
     * Init the waiter.
     */
    public function init()
    {
        // no-op
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
        // no-op
    }
}
