<?php

namespace Afonso\Prok\Tests;

use Afonso\Prok\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleCommand()
    {
        $command = new Command('foo');
        $this->assertEquals("foo", (string) $command);
    }

    public function testCommandWithOptions()
    {
        $command = new Command('foo');
        $command->addOption('bar', 'baz');
        $command->addOption('abc', 'def');
        $command->addOption('noValue');

        $expected = 'foo --bar=baz --abc=def --noValue';
        $this->assertEquals($expected, (string) $expected);
    }

    public function testCommandWithFlags()
    {
        $command = new Command('foo');
        $command->addFlag('a');
        $command->addFlag('B');
        $command->addFlag('x');
        $command->addFlag('z');

        $this->assertEquals('foo -aBxz', (string) $command);
    }

    public function testCommandWithArgument()
    {
        $command = new Command('foo');
        $command->setArgument('bar baz quux');

        $this->assertEquals('foo bar baz quux', (string) $command);
    }

    public function testCommandWithEverything()
    {
        $command = new Command('foo');
        $command->addOption('bar', 'baz');
        $command->addFlag('a');
        $command->addFlag('B');
        $command->addFlag('c');
        $command->setArgument('quux');

        $expected = 'foo --bar=baz --abc=def --noValue';
        $this->assertEquals($expected, (string) $expected);
    }
}
