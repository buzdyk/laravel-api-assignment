<?php

namespace Database\Factories;

use App\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlayerFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Player' . $this->faker->firstName(),
            'position' => $this->faker->randomElement(PlayerPosition::cases()),
        ];
    }

    public function midfielder()
    {
        return $this->state(function () {
            return [
                'position' => PlayerPosition::MIDFIELDER,
            ];
        });
    }

    public function forward()
    {
        return $this->state(function () {
            return [
                'position' => PlayerPosition::FORWARD,
            ];
        });
    }

    public function defender()
    {
        return $this->state(function () {
            return [
                'position' => PlayerPosition::DEFENDER,
            ];
        });
    }
}
