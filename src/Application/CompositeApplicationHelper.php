<?php

namespace RemiSan\Ouroboros\Application;

use RemiSan\Ouroboros\ApplicationHelper;

class CompositeApplicationHelper implements ApplicationHelper
{
    /** @var ApplicationHelper[] */
    private $helpers;

    /**
     * CompositeApplicationHelper constructor.
     *
     * @param ApplicationHelper[] $helpers
     */
    public function __construct(array $helpers = [])
    {
        $this->helpers = [];

        foreach ($helpers as $helper) {
            $this->addHelper($helper);
        }
    }

    /**
     * @param ApplicationHelper $helper
     */
    public function addHelper(ApplicationHelper $helper)
    {
        $this->helpers[] = $helper;
    }

    /**
     * Start the application.
     */
    public function start()
    {
        foreach ($this->helpers as $helper) {
            $helper->start();
        }
    }

    /**
     * Stop the application.
     */
    public function stop()
    {
        foreach ($this->helpers as $helper) {
            $helper->stop();
        }
    }
}
