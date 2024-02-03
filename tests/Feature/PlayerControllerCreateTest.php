<?php


// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;


use App\Models\Player;

class PlayerControllerCreateTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $data = $this->validFormdata();

        $res = $this->postJson(self::REQ_URI, $data);

        $this->assertNotNull($res);
    }

    public function test_it_creates_a_player_with_skills()
    {
        $data = $this->validFormdata();

        $res = $this->postJson(self::REQ_URI, $data);

        $res->assertStatus(200);

        $this->assertPlayerJsonStructure($res->json());
        $this->assertEquals(1, Player::count());

        $player = Player::first();

        $this->assertEquals($data['name'], $player->name);
        $this->assertEquals($data['position'], $player->position->value);

        foreach ($player->skills as $i => $skill) {
            $this->assertEquals($data['playerSkills'][$i]['skill'], $skill->skill->value);
            $this->assertEquals($data['playerSkills'][$i]['value'], $skill->value);
        }
    }

    public function test_it_validates_input_and_provides_error_in_expected_format()
    {
        $data = $this->validFormdata(['position' => 'carry']);
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);

        $this->assertEquals('Invalid value for position: carry', $res->json('message'));

        $data = $this->validFormdata(['playerSkills' => [0 => ['skill' => 'heal']]]);
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);

        // note on a bit ugly playerSkills.0.skill
        // message replacer won't work in lang/validation 'custom' => or in CreateOrUpdatePlayer::messages
        // fixing it would require reading source code or writing a custom replacer
        // which is presumably outside the test assignment scope
        $this->assertEquals('Invalid value for playerSkills.0.skill: heal', $res->json('message'));

        $data = $this->validFormdata(['position' => 'carry', 'playerSkills' => [0 => ['skill' => 'heal']]]);
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
        $this->assertCount(1, $res->json(), 'validation response contains only one field');
    }

    private function validFormdata(array $mergeIn = [])
    {
        return array_merge([
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
            ],
        ], $mergeIn);
    }
}
