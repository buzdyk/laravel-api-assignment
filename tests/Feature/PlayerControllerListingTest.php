<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;

class PlayerControllerListingTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $res = $this->get(self::REQ_URI);

        $this->assertNotNull($res);
    }

    public function test_it_lists_players_when_they_exist()
    {
        Player::factory()->count(5)->create();

        $res = $this->get(self::REQ_URI);

        $this->assertEquals(5, count($res->json()));

        foreach ($res->json() as $player) {
            $this->assertPlayerJsonStructure($player);
        }
    }

    public function test_it_doesnt_list_players_if_no_players()
    {
        $res = $this->get(self::REQ_URI);

        $this->assertEquals(0, count($res->json()));
    }
}
