<?php

namespace App\Validators;

use Illuminate\Support\Str;

class KeywordValidator extends Validator implements BaseValidator
{
    protected $invalidValuesForOptions = [
        'legal_name' => ['Corp', 'Inc', 'PA'],
        'trade_name' => ['LLC', 'LC', 'PLLC', 'PA', 'Corp', 'Inc'],
    ];

    public function handle($validValuesForOptions, $key, $answer, $question)
    {
        if (array_key_exists($key, $this->invalidValuesForOptions)) {
            $invalidValuesForOption = $this->invalidValuesForOptions[$key];

            foreach ($invalidValuesForOption as $invalidValueForOption) {
                if (Str::contains($answer, $invalidValueForOption)) {
                    $this->error = "Invalid answer detected: `{$answer}`. Answer for the question `{$question}` must not contain words such as: " . implode(', ', $invalidValuesForOption);

                    return $this->error;
                }
            }

            return true;
        }

        return $this->error;
    }
}
