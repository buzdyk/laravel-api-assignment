<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Enums\PlayerPosition;
use App\Http\Requests\CreateOrUpdatePlayer;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return response("Failed", 500);
    }

    public function show()
    {
        return response("Failed", 500);
    }

    public function store(CreateOrUpdatePlayer $request)
    {
        $data = $request->safe();

        $player = Player::create($data->only(['name', 'position']));
        $player->syncSkills($data['playerSkills'], false);

        return response(new PlayerResource($player));
    }

    public function update(Player $player, CreateOrUpdatePlayer $request)
    {
        $data = $request->safe();

        $player->update($data->only(['name', 'position']));
        $player->syncSkills($data['playerSkills'], true);

        return response(new PlayerResource($player));
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return response("Failed", 200);
    }
}
