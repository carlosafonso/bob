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
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];
        $proc = proc_open($command, $descriptors, $pipes);

        if ($input) {
            fwrite($pipes[0], $input);
            fclose($pipes[0]);
        }

        $out = null;
        while ($line = fgets($pipes[1])) {
            $out .= $line;
        }
        fclose($pipes[1]);

        $err = null;
        while ($line = fgets($pipes[2])) {
            $err .= $line;
        }
        fclose($pipes[2]);

        $ret = proc_close($proc);

        $output = new Output($ret, $out, $err);
        return $output;
    }
}
