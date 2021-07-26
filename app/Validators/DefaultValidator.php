<?php

namespace App\Validators;

class DefaultValidator extends Validator implements BaseValidator
{
    // default validator fallback
    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (is_array($validValuesForOptions)) {
            $validAnswers = [];
            foreach ($validValuesForOptions as $validAnswer) {
                if ($validAnswer === true) {
                    $validAnswers[] = 'true';
                } elseif ($validAnswer === false) {
                    $validAnswers[] = 'false';
                } else {
                    $validAnswers[] = $validAnswer;
                }
            }

            // also check if last option is 'other' if so, accept any value
            if (in_array($answer, $validValuesForOptions, true) || end($validValuesForOptions) === 'Other') {
                return true;
            }

            $this->error = "Invalid answer detected: `{$answer}`. Valid answers for the question `{$question}` are: " . implode(', ', $validAnswers);
        }

        return $this->error;
    }
}
