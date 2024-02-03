<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class PlayerControllerBaseTest extends TestCase
{
    use RefreshDatabase;

    final const REQ_URI = '/api/player/';
    final const REQ_TEAM_URI = '/api/team/process';

    protected function log($data){
        fwrite(STDERR, print_r($data, TRUE));
    }

    /**
     * todo validate data, add $player param to optionally assert the data
     * @param array $json
     * @return void
     */
    protected function assertPlayerJsonStructure(array $json)
    {
        $this->assertArrayHasKey('name', $json);
        $this->assertIsString($json['name']);

        $this->assertArrayHasKey('position', $json);
        $this->assertIsString($json['position']);

        $this->assertArrayHasKey('playerSkills', $json);
        $this->assertIsArray($json['playerSkills']);

        foreach ($json['playerSkills'] as $playerSkill) {
            $this->assertArrayHasKey('skill', $playerSkill);
            $this->assertIsString($playerSkill['skill']);

            $this->assertArrayHasKey('value', $playerSkill);
            $this->assertIsNumeric($playerSkill['value']);
        }
    }
}
