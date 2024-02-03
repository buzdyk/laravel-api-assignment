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

    public function stamina($value = null)
    {
        return $this->state(function () use ($value) {
            return [
                'skill' => PlayerSkill::STAMINA,
                'value' => $value ?? $this->faker->numberBetween(1, 100)
            ];
        });
    }

    public function defense(int $value = null)
    {
        return $this->state(function () use ($value) {
            return [
                'skill' => PlayerSkill::DEFENSE,
                'value' => $value ?? $this->faker->numberBetween(1, 100)
            ];
        });
    }

    public function attack(int $value = null)
    {
        return $this->state(function () use ($value) {
            return [
                'skill' => PlayerSkill::ATTACK,
                'value' => $value ?? $this->faker->numberBetween(1, 100)
            ];
        });
    }

    public function speed(int $value = null)
    {
        return $this->state(function () use ($value) {
            return [
                'skill' => PlayerSkill::SPEED,
                'value' => $value ?? $this->faker->numberBetween(1, 100)
            ];
        });
    }

    public function strength(int $value = null)
    {
        return $this->state(function () use ($value) {
            return [
                'skill' => PlayerSkill::STRENGTH,
                'value' => $value ?? $this->faker->numberBetween(1, 100)
            ];
        });
    }
}
