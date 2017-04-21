<?php

namespace RemiSan\Ouroboros\Infrastructure;

use RemiSan\Ouroboros\Command\CommandExecuter;
use RemiSan\Ouroboros\InfrastructureHelper;

class NullInfrastructureHelper implements InfrastructureHelper
{
    /**
     * Build the infrastructure.
     *
     *
     * @throws \RuntimeException
     */
    public function build()
    {
        // no-op
    }

    /**
     * Destroy the infrastructure.
     *
     *
     * @throws \RuntimeException
     */
    public function destroy()
    {
        // no-op
    }
}
