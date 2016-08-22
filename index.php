<?php

/**
 * Class Machine
 * The idea is taken from https://rosettacode.org/wiki/Universal_Turing_machine and written in a much
 * simpler implementation for PHP.
 * Some ideas are taken from https://github.com/igorw/turing-php (for example, the '_' symbol appending on empty spaces),
 * however, the mentioned implementation is incorrect as it features the State of the machine as the main object.
 */

class Machine
{
    const MOVE_RIGHT = 'R';
    const MOVE_LEFT = 'L';

    protected $line;

    protected $position;

    protected $state;

    protected $rules;

    protected $acceptedStates;

    /**
     * Construct the machine with the current state
     *
     * @var array $line
     * @var integer $position
     * @var string $state
     * @var array $rules
     * @var array $acceptedStates
     */
    function __construct($line, $position, $state, $rules, $acceptedStates)
    {
        $this->line = $line;
        $this->position = $position;
        $this->state = $state;
        $this->rules = $rules;
        $this->acceptedStates = $acceptedStates;
    }

    /**
     * Move the tape to the left. If the position is already 0, write a '_'in the 0 position.
     */
    function moveLeft()
    {
        $this->position--;
        if ($this->position < 0) {
            $this->position++;
            array_unshift($this->line, '_');
        }
    }

    /**
     * Move the tape to the right. If the position is already last one, write a '_' in the last position.
     */
    function moveRight()
    {
        $this->position++;
        if ($this->position >= count($this->line)) {
            array_push($this->line, '_');
        }
    }

    /**
     *  Return either the current element or '_'
     *
     * @var $position
     * @return string
     */
    function readLine($position)
    {

        return isset($this->line[$position]) ? $this->line[$position] : '_';
    }

    /**
     * Searches for the matching rule for the given value in current state.
     * If none is found, becomes useless and throws an exception.
     *
     * @var array $cell
     * @return array
     */
    function matchRule()
    {
        $value = $this->readLine($this->position);

        if (!isset($this->rules[$this->state][$value])) {

            var_dump('No rule found for value ' . $value);
            die;
        }

        return $this->rules[$this->state][$value];
    }

    /**
     * Iterate over a step - change the current position, save something to the output line, save the next step.
     *
     * @var array $rule
     */
    function step($rule)
    {
        $output = $rule[0];
        $direction = $rule[1];
        $nextState = $rule[2];

        $this->line[$this->position] = $output;

        switch ($direction) {
            case self::MOVE_LEFT:
                $this->moveRight();
                break;
            case self::MOVE_RIGHT:
                $this->moveRight();
                break;
            default:
                var_dump('Illegal direction given in position ' . $this->position);
                break;
        }

        $this->state = $nextState;
    }

    /**
     * Iterate over the rules to do some cool stuff.
     */
    function run()
    {
        while (!in_array($this->state, $this->acceptedStates)) {
            $rule = $this->matchRule();
            $this->step($rule);
        }

        return $this->line;
    }
}

/**
 * Possible use of the program. We'll usually call the class Machine from the other file using namespaces, but for
 * demonstration purposes all is done in one file.
 */
$acceptedStates = [7];
$rules = [
    0 => ['_' => ['S', 'R', 1]],
    1 => ['_' => ['T', 'R', 2]],
    2 => ['_' => ['5', 'R', 3]],
    3 => ['_' => ['6', 'R', 4]],
    4 => ['_' => ['5', 'R', 5]],
    5 => ['_' => ['2', 'R', 6]],
    6 => ['_' => ['3', 'R', 7]],
];

$tape = [];
$position = 0;
$state = 0;

$machine = new Machine($tape, $position, $state, $rules, $acceptedStates);

$output = $machine->run();
echo implode('', $output);
