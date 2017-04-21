<?php

namespace RemiSan\Ouroboros\Application;

use RemiSan\Ouroboros\ApplicationHelper;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class NullApplicationHelper implements ApplicationHelper
{
    /**
     * Start the application.
     */
    public function start()
    {
        // no-op
    }

    /**
     * Stop the application.
     */
    public function stop()
    {
        // no-op
    }
}
