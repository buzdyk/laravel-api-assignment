<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;


use App\Models\Player;
use App\Models\PlayerSkill;
use Database\Factories\PlayerSkillFactory;

class TeamControllerTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $requirements =
            [
                'position' => "defender",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ];


        $res = $this->postJson(self::REQ_TEAM_URI, $requirements);

        $this->assertNotNull($res);
    }

    public function ddtest_it_returns_matches()
    {
        $mid1 = Player::factory()->midfielder()->create();
        PlayerSkill::factory()->speed(90)->create(['player_id' => $mid1->id]);
        PlayerSkill::factory()->defense(50)->create(['player_id' => $mid1->id]);

        $mid2 = Player::factory()->midfielder()->create();
        PlayerSkill::factory()->attack(10)->create(['player_id' => $mid2->id]);
        PlayerSkill::factory()->stamina(60)->create(['player_id' => $mid2->id]);

        $mid3 = Player::factory()->midfielder()->create();
        PlayerSkill::factory()->strength(15)->create(['player_id' => $mid3->id]);

        $fwd1 = Player::factory()->forward()->create();
        PlayerSkill::factory()->strength(100)->create(['player_id' => $fwd1->id]);

        $res = $this->postJson(self::REQ_TEAM_URI, [
            [
                'position' => "midfielder",
                'mainSkill' => "strength",
                'numberOfPlayers' => 2
            ],

            [
                'position' => "forward",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ],
        ]);

        $res->assertStatus(200);

        $this->assertEquals($res[0][0]['id'], $mid3->id);
        $this->assertEquals($res[0][1]['id'], $mid1->id);
        $this->assertEquals($res[1][0]['id'], $fwd1->id);
    }

    public function test_it_rejects_duplicate_pairs()
    {
        $res = $this->postJson(self::REQ_TEAM_URI, [
            [
                'position' => "defender",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ],
            [
                'position' => "midfielder",
                'mainSkill' => "defense",
                'numberOfPlayers' => 1
            ],
            [
                'position' => "defender",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ]
        ]);

        $res->assertStatus(422);
        $this->assertEquals($res->json('message'), 'Duplicate position/skill pair');
    }
}
