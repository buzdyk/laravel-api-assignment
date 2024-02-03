<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use App\Exceptions\InsufficientPlayersException;
use App\Http\Requests\TeamProcessRequest;
use App\Http\Resources\PlayerResource;
use App\Services\TeamSelector;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function process(TeamProcessRequest $request)
    {
        $this->checkForDuplicatePairs($request);

        $service = new TeamSelector();
        $res = [];

        foreach ($request->safe() as $query) {
            try {
                $players = $service->getPlayers(
                    PlayerPosition::from($query['position']),
                    PlayerSkill::from($query['mainSkill']),
                    $query['numberOfPlayers'],
                );

                $res[] = PlayerResource::collection($players);
            } catch (InsufficientPlayersException $e) {
                $this->throwValidationException('Insufficient number of players for position: ' . $query['position']);
            }
        }

        return response($res);
    }

    protected function checkForDuplicatePairs(TeamProcessRequest $request)
    {
        $acc = [];

        foreach ($request->safe() as $item) {
            $pos = $item['position'];
            $skill = $item['mainSkill'];

            if (!isset($acc[$pos])) { $acc[$pos] = []; }

            if (!isset($acc[$pos][$skill])) {
                $acc[$pos][$skill] = true; continue;
            }

            $this->throwValidationException('Duplicate position/skill pair');
        }
    }
}
