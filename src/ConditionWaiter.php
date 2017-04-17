<?php

namespace RemiSan\Ouroboros;

use Assert\AssertionFailedException;
use LogicException;
use Symfony\Component\Process\Exception\RuntimeException;

interface ConditionWaiter
{
    /**
     * @param string $delimiter
     */
    public static function changeDelimiter($delimiter);

    /**
     * Init the waiter.
     */
    public function init();

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
    public function wait(array $conditions);
}
