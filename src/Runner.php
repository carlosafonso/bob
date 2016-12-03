<?php

namespace Afonso\Prok;

/**
 * A command runner.
 */
class Runner
{
    /**
     * Run the specified command, optionally
     * passing the provided input through stdin.
     *
     * @param string $command
     * @param mixed|null $input
     * @return \Afonso\Prok\Output
     */
    public function run($command, $input = null)
    {
        $proc = proc_open($command, [0 => ['pipe', 'r'], 1 => ['pipe', 'w']], $pipes);

        if ($input) {
            fwrite($pipes[0], $stdIn);
            fclose($pipes[0]);
        }

        $out = fgets($pipes[1]);
        fclose($pipes[1]);
        $ret = proc_close($proc);

        $output = new Output($ret, $out);
        return $output;
    }
}
