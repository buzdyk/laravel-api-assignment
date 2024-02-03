<?php

namespace Database\Factories;

use App\Enums\PlayerSkill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlayerSkillFactory extends Factory
{
    public function definition()
    {
        return [
            'skill' => $this->faker->randomElement(PlayerSkill::cases()),
            'value' => $this->faker->numberBetween(1, 100),
        ];
    }
}
