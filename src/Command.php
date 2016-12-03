<?php

namespace Afonso\Prok;

/**
 * A runnable command.
 */
class Command
{
    /**
     * The command itself.
     *
     * @var string
     */
    protected $command;

    /**
     * The options to be passed to this command.
     *
     * @var string[]
     */
    protected $options = [];

    /**
     * The flags to be passed to this command.
     *
     * @var string[]
     */
    protected $flags = [];

    /**
     * Additional arguments to be passed to this
     * command.
     *
     * @var string
     */
    protected $argument;

    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Set the command.
     *
     * @param string $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * Add an option to this command.
     *
     * @var string $name
     * @var string|null $value
     */
    public function addOption($name, $value = null)
    {
        $this->options[$name] = $value;
    }

    /**
     * Add a flag to this command.
     *
     * @var string $flag
     */
    public function addFlag($flag)
    {
        if (! in_array($flag, $this->flags)) {
            $this->flags[] = $flag;
        }
    }

    /**
     * Set the argument of this command.
     *
     * @var string $argument
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;
    }

    /**
     * Return the string representation of this
     * command, which is the string that can be
     * used on a shell to launch it.
     *
     * @return string
     */
    public function __toString()
    {
        $commandString = $this->command;

        if (count($this->options)) {
            $options = [];
            foreach ($this->options as $opt => $val) {
                if ($val) {
                    $options[] = "--{$opt}={$val}";
                } else {
                    $options[] = "--{$opt}";
                }
            }
            $commandString .= ' ' . join(' ', $options);
        }

        if (count($this->flags)) {
            $commandString .= ' -' . join('', $this->flags);
        }

        $commandString .= ' ' . $this->argument;

        return trim($commandString);
    }
}
