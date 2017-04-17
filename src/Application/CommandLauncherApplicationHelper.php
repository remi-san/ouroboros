<?php

namespace RemiSan\Ouroboros\Application;

use RemiSan\Ouroboros\ApplicationHelper;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class CommandLauncherApplicationHelper implements ApplicationHelper
{
    /** @var string */
    private $basePath;

    /** @var string */
    private $command;

    /** @var Process */
    private $worker;

    /**
     * MakefileInfrastructureHelper constructor.
     *
     * @param string $basePath
     * @param        $command
     */
    public function __construct($basePath, $command)
    {
        $this->basePath = $basePath;
        $this->command = $command;
    }

    /**
     * Start the application.
     *
     *
     * @throws \RuntimeException
     * @throws RuntimeException
     * @throws LogicException
     */
    public function start()
    {
        $this->worker = new Process($this->command, $this->basePath);
        $this->worker->start(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > ' . $buffer; // TODO better than echo?
            }
        });
    }

    /**
     * Stop the application.
     *
     *
     * @throws \RuntimeException
     */
    public function stop()
    {
        if ($this->worker === null) {
            return;
        }

        $this->worker->stop(1, SIGTERM);
        $this->worker = null;
    }
}
