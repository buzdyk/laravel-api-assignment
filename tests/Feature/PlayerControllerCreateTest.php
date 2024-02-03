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
        $data = $this->validFormdata(['position' => 'invalid position string']);
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);

        $data = $this->validFormdata(['playerSkills' => [0 => ['skill' => 'invalid skill string']]]);
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
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
