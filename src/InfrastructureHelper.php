<?php

namespace RemiSan\Ouroboros;

interface InfrastructureHelper
{
    /**
     * Build the infrastructure.
     */
    public function build();

    /**
     * Destroy the infrastructure.
     */
    public function destroy();
}
