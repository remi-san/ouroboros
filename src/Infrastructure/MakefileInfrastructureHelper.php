<?php

namespace RemiSan\Ouroboros\Infrastructure;

use RemiSan\Ouroboros\Command\CommandExecuter;
use RemiSan\Ouroboros\InfrastructureHelper;

class MakefileInfrastructureHelper implements InfrastructureHelper
{
    /** @var string */
    private $basePath;

    /**
     * MakefileInfrastructureHelper constructor.
     *
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Build the infrastructure.
     *
     *
     * @throws \RuntimeException
     */
    public function build()
    {
        CommandExecuter::executeCommand('make install-infrastructure', $this->basePath);
    }

    /**
     * Destroy the infrastructure.
     *
     *
     * @throws \RuntimeException
     */
    public function destroy()
    {
        CommandExecuter::executeCommand('make uninstall-infrastructure', $this->basePath);
    }
}
