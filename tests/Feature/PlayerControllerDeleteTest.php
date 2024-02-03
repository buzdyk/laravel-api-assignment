<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;
use Database\Factories\PlayerFactory;

class PlayerControllerDeleteTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $res = $this->delete(self::REQ_URI . '1');

        $this->assertNotNull($res);
    }

    public function test_it_rejects_requests_with_incorrect_auth_header()
    {
        // bindings middleware runs before route middleware so
        // feature, not a bug https://github.com/laravel/framework/issues/6118
        $res = $this->delete(self::REQ_URI . 1);
        $res->assertStatus(404);

        $player = Player::factory()->create();
        $res = $this->delete(self::REQ_URI . $player->id);
        $res->assertStatus(403);

        $res = $this->delete(self::REQ_URI . '1', [], [
            'Authorization' => 'Bearer invalid_token'
        ]);
        $res->assertStatus(403);
    }

    public function test_it_deletes_an_existing_player()
    {
        $players = Player::factory()->count(3)->create();

        $res = $this->delete(self::REQ_URI . $players[1]->id, [], [
            'Authorization' => 'Bearer SkFabTZibXE1aE14ckpQUUxHc2dnQ2RzdlFRTTM2NFE2cGI4d3RQNjZmdEFITmdBQkE='
        ]);
        $res->assertStatus(200);
        $this->assertEquals(2, Player::count());
        $this->assertNull($players[1]->fresh());
    }

    public function test_it_returns_404_if_player_not_found()
    {
        $players = Player::factory()->count(3)->create();

        $res = $this->delete(self::REQ_URI . $players[2]->id + 1, [], [
            'Authorization' => 'Bearer SkFabTZibXE1aE14ckpQUUxHc2dnQ2RzdlFRTTM2NFE2cGI4d3RQNjZmdEFITmdBQkE='
        ]);
        $res->assertStatus(404);
        $this->assertEquals(3, Player::count());
    }
}
