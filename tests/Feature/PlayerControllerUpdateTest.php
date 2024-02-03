<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;


use App\Enums\PlayerPosition as PlayerPositionEnum;
use App\Enums\PlayerSkill as PlayerSkillEnum;
use App\Models\Player;
use App\Models\PlayerSkill;
use Illuminate\Foundation\Testing\WithFaker;

class PlayerControllerUpdateTest extends PlayerControllerBaseTest
{
    use WithFaker;

    public function test_sample()
    {
        $data = [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . '1', $data);

        $this->assertNotNull($res);
    }

    public function test_it_updates_a_player()
    {
        $player = Player::factory()->create([
            'position' => PlayerPositionEnum::DEFENDER->value
        ]);

        PlayerSkill::factory()->create(['player_id' => $player->id, 'skill' => PlayerSkillEnum::ATTACK->value]);
        PlayerSkill::factory()->create(['player_id' => $player->id, 'skill' => PlayerSkillEnum::DEFENSE->value]);

        $this->assertEquals(2, $player->skills()->count());
        $this->assertEquals(1, $player->skills()->where('skill', PlayerSkillEnum::ATTACK->value)->count());
        $this->assertEquals(1, $player->skills()->where('skill', PlayerSkillEnum::DEFENSE->value)->count());

        $skillsPayload = [
            'defense' => [
                'skill' => PlayerSkillEnum::DEFENSE->value,
                'value' => $this->faker->numberBetween(1, 100),
            ],
            'stamina' => [
                'skill' => PlayerSkillEnum::STAMINA->value,
                'value' => $this->faker->numberBetween(1, 100),
            ]
        ];

        $payload = [
            'name' => $this->faker->firstName,
            'position' => PlayerPositionEnum::FORWARD->value,
            'playerSkills' => $skillsPayload
        ];

        $res = $this->putJson(self::REQ_URI . $player->id, $payload);
        $res->assertStatus(200);

        $player = $player->fresh();

        $this->assertEquals($payload['name'], $player->name);
        $this->assertEquals($payload['position'], $player->position->value);
        $this->assertEquals(2, $player->skills()->count());

        foreach ($player->skills as $skill) {
            $this->assertTrue(array_key_exists($skill->skill->value, $skillsPayload));
            $this->assertEquals($skillsPayload[$skill->skill->value]['value'], $skill->value);
        }

        // todo validate response as well
    }

    public function it_fails_if_input_is_not_valid()
    {
        $data = [];

        $res = $this->putJson(self::REQ_URI . '1', $data);
        $res->assertStatus(422);
    }
}
