<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueFieldInArray implements Rule
{
    protected $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value) === false) {
            return false;
        }

        $values = array_unique(
            array_column($value, $this->field)
        );

        return count($values) === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Each :attribute must be unique.';
    }
}
