<?php

namespace RemiSan\Ouroboros\Command;

class CommandExecuter
{
    /**
     * Execute a CLI command.
     *
     * @param string $cmd
     * @param string $path
     *
     * @throws \RuntimeException
     */
    public static function executeCommand($cmd, $path = null)
    {
        $returnArray = [];
        $returnValue = 0;

        $command = ($path ? 'cd ' . $path . ' && ' : '') . $cmd;

        exec($command, $returnArray, $returnValue);

        if ($returnValue !== 0) {
            throw new \RuntimeException(sprintf('Command "%s" failed : %s', $cmd, implode("\n", $returnArray)));
        }
    }
}
