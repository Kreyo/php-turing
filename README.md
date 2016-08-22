# Universal Turing Machine emulator based on PHP

## Usage 

The Machine object is not designed to be used by itself, but rather called as an object in your PHP application.
Simply instantiate the Machine class by constructing it with required parameters, call the run() method, and enjoy the result.

## Parameters
 - $tape = input tape of type array
 - $position = initial position of the read\write head, integer
 - $state = initial state of the machine in integer\string format
 - $rules = array of rules for each state, see example in the final section of the code
 - $acceptedStates = array of exit conditions
