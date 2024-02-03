<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;


class PlayerControllerUpdateTest extends PlayerControllerBaseTest
{
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

    public function it_updates_a_player()
    {
        $data = [];

        $res = $this->putJson(self::REQ_URI . '1', $data);
        $res->assertStatus(422);
    }

    public function it_fails_if_input_is_not_valid()
    {
        $data = [];

        $res = $this->putJson(self::REQ_URI . '1', $data);
        $res->assertStatus(422);
    }
}
