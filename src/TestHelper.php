<?php

namespace RemiSan\Ouroboros;

use Assert\AssertionFailedException;
use Symfony\Component\Process\Exception\RuntimeException;

class TestHelper
{
    /** @var InfrastructureHelper */
    private $infrastructureHelper;

    /** @var ApplicationHelper */
    private $applicationHelper;

    /** @var ConditionWaiter */
    private $waiter;

    /**
     * TestHelper constructor.
     *
     * @param InfrastructureHelper $infrastructureHelper
     * @param ApplicationHelper    $applicationHelper
     * @param ConditionWaiter      $waiter
     */
    public function __construct(
        InfrastructureHelper $infrastructureHelper,
        ApplicationHelper $applicationHelper,
        ConditionWaiter $waiter
    ) {
        $this->infrastructureHelper = $infrastructureHelper;
        $this->applicationHelper = $applicationHelper;
        $this->waiter = $waiter;
    }

    /**
     * Setup the test.
     */
    public function setUp()
    {
        $this->tearDown();

        $this->infrastructureHelper->build();
        $this->applicationHelper->start();

        $this->waiter->init();
    }

    /**
     * Tear down the test.
     */
    public function tearDown()
    {
        $this->applicationHelper->stop();
        $this->infrastructureHelper->destroy();
    }

    /**
     * Wait for completion.
     *
     * @param array $conditions
     *
     * @throws \LogicException
     * @throws \RuntimeException
     * @throws RuntimeException
     * @throws AssertionFailedException
     */
    public function wait(array $conditions)
    {
        $this->waiter->wait($conditions);
    }
}
