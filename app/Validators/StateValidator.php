<?php

namespace App\Validators;

class StateValidator extends Validator implements BaseValidator
{
    // validate for state field
    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (! is_array($validValuesForOptions) && in_array($validValuesForOptions, ['states', 'state-code'])) {
            $validValuesForOptions = $this->states;

            if (in_array($answer, $validValuesForOptions)) {
                return true;
            }

            $this->error = "Invalid answer detected: `{$answer}`. Valid answers for the question `{$question}` are: " . implode(', ', $validValuesForOptions);
        }

        return $this->error;
    }
}
