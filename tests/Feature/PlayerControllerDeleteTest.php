<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

class PlayerControllerDeleteTest extends PlayerControllerBaseTest
{

    public function test_sample()
    {
        $res = $this->delete(self::REQ_URI . '1');

        $this->assertNotNull($res);
    }

    public function it_is_protected_with_bearer_auth()
    {
        $res = $this->delete(self::REQ_URI . '1', [
            'authorization' => 'Bearer invalid_token'
        ]);

        $res->assertStatus(403);

        $res = $this->delete(self::REQ_URI . '1', [
            'authorization' => 'Bearer invalid_token'
        ]);

        $res->assertStatus(200);
    }

    public function it_deletes_an_existing_player()
    {
        $res = $this->delete(self::REQ_URI . '1');
        $res->assertStatus(200);
    }

    public function it_returns_404_if_player_not_found()
    {
        $res = $this->delete(self::REQ_URI . '1');
        $res->assertStatus(404);
    }
}
