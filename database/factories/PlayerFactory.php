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
}
