<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Enums\PlayerPosition;
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

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:20',
            'position' => 'required|in:' . join(',', PlayerPosition::cases()),
            'playerSkills' => 'required|min:1',
            'playerSkills.skill' => 'required|string|unique|in:' . join(',', PlayerPosition::cases()),
            'playerSkills.value' => 'required|numeric|min:1|max:100',
        ]);

        return response("Failed", 500);
    }

    public function update(Player $player, Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:20',
            'position' => 'required|in:' . join(',', PlayerPosition::cases()),
            'playerSkills' => 'required|min:1',
            'playerSkills.skill' => 'required|string|unique|in:' . join(',', PlayerPosition::cases()),
            'playerSkills.value' => 'required|numeric|min:1|max:100',
        ]);

        return response("Failed", 500);
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return response("Failed", 200);
    }
}
